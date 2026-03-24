<?php

namespace App\Http\Controllers;

use App\Models\EconomicData;
use App\Models\Province;
use App\Models\Region;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegionDataImportController extends Controller
{
    private const SESSION_KEY = 'region_data_import';

    public function showUpload()
    {
        return view('pages.imports.region-data.upload');
    }

    public function handleUpload(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
            'data_type' => ['required', 'in:motor_vehicles,banking_liabilities,operating_income'],
            'has_header' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('csv_file')->store('imports');
        $delimiter = $this->detectDelimiter(Storage::path($path));
        $hasHeader = (bool) ($validated['has_header'] ?? true);

        [$headers, $previewRows] = $this->readHeadersAndPreview(Storage::path($path), $hasHeader, $delimiter, 8);
        $suggestedMapping = $this->suggestMapping($headers, $validated['data_type']);

        session()->put(self::SESSION_KEY, [
            'path' => $path,
            'has_header' => $hasHeader,
            'delimiter' => $delimiter,
            'headers' => $headers,
            'data_type' => $validated['data_type'],
        ]);

        return redirect()
            ->route('imports.region-data.mapping')
            ->with('preview_rows', $previewRows)
            ->with('suggested_mapping', $suggestedMapping);
    }

    public function showMapping()
    {
        $state = session()->get(self::SESSION_KEY);
        if (!$state) {
            return redirect()->route('imports.region-data')->withErrors(['csv_file' => 'Please upload a CSV file first.']);
        }

        $headers = $state['headers'];
        $dataType = $state['data_type'];
        $fields = $this->fieldsForType($dataType);
        $previewRows = session()->get('preview_rows', []);
        $suggestedMapping = session()->get('suggested_mapping', $this->suggestMapping($headers, $dataType));

        return view('pages.imports.region-data.mapping', compact('headers', 'fields', 'previewRows', 'suggestedMapping', 'dataType'));
    }

    public function import(Request $request)
    {
        $state = session()->get(self::SESSION_KEY);
        if (!$state) {
            return redirect()->route('imports.region-data')->withErrors(['csv_file' => 'Please upload a CSV file first.']);
        }

        $dataType = $state['data_type'];
        $fields = $this->fieldsForType($dataType);

        $mappingRules = [];
        foreach ($fields as $field => $meta) {
            $rules = [];
            if ($meta['required']) {
                $rules[] = 'required';
            }
            $rules[] = 'nullable';
            $mappingRules["mapping.$field"] = $rules;
        }

        $validated = $request->validate(array_merge($mappingRules, [
            'skip_invalid' => ['nullable', 'boolean'],
        ]));

        $mapping = $validated['mapping'] ?? [];
        $skipInvalid = (bool) ($validated['skip_invalid'] ?? true);

        $filePath = Storage::path($state['path']);
        $rows = $this->iterateRows($filePath, $state['has_header'], $state['delimiter']);

        $region = Region::firstOrCreate(['code' => 'R3'], ['name' => 'Region III']);
        $provinceMap = $this->provinceMap($region->id);

        $imported = 0;
        $skipped = 0;
        $warnings = [];

        foreach ($rows as $rowNumber => $row) {
            $data = $this->mapRow($row, $mapping);
            $provinceValue = $this->normalizeProvince($data['province'] ?? null);
            $year = isset($data['year']) ? (int) $data['year'] : null;

            if (!$year) {
                $warnings[] = "Row {$rowNumber}: Missing or invalid year.";
                $skipped++;
                if ($skipInvalid) {
                    continue;
                }
            }

            $provinceId = null;
            if ($provinceValue && $provinceValue !== 'region iii') {
                if (!isset($provinceMap[$provinceValue])) {
                    $warnings[] = "Row {$rowNumber}: Province '{$data['province']}' is not in Region III. Skipped.";
                    $skipped++;
                    continue;
                }
                $provinceId = $provinceMap[$provinceValue];
            }

            $payload = $this->sanitizeRow($data, $fields);
            $payload['region_id'] = $region->id;
            $payload['province_id'] = $provinceId;
            $payload['year'] = $year;
            $payload['province'] = $provinceValue === 'region iii'
                ? 'Region III'
                : ($data['province'] ?? null);

            if ($dataType === 'motor_vehicles') {
                VehicleRegistration::withTrashed()->updateOrCreate(
                    [
                        'region_id' => $region->id,
                        'province_id' => $provinceId,
                        'year' => $year,
                    ],
                    [
                        'classification' => 'total',
                        'province' => $payload['province'],
                        'private' => (int) ($payload['private'] ?? 0),
                        'private_vehicles' => (int) ($payload['private'] ?? 0),
                        'for_hire' => (int) ($payload['for_hire'] ?? 0),
                        'government' => (int) ($payload['government'] ?? 0),
                        'diplomatic' => (int) ($payload['diplomatic'] ?? 0),
                        'exempt' => (int) ($payload['exempt'] ?? 0),
                        'total' => (int) ($payload['total'] ?? 0),
                    ]
                );
            } else {
                $total = $payload['total'] ?? null;
                $dataTypeKey = $dataType === 'banking_liabilities' ? 'banking_liabilities' : 'operating_income';
                EconomicData::withTrashed()->updateOrCreate(
                    [
                        'region_id' => $region->id,
                        'province_id' => $provinceId,
                        'year' => $year,
                        'data_type' => $dataType,
                    ],
                    [
                        'total' => $total,
                        'banking_liabilities' => $dataType === 'banking_liabilities' ? $total : null,
                        'operating_income' => $dataType === 'operating_income' ? $total : null,
                        'universal_commercial_banks' => $payload['universal_commercial_banks'] ?? null,
                        'thrift_banks' => $payload['thrift_banks'] ?? null,
                        'rural_cooperative_banks' => $payload['rural_cooperative_banks'] ?? null,
                        'province' => $payload['province'],
                        // legacy fields for backward compatibility
                        'universal_banks' => $payload['universal_commercial_banks'] ?? null,
                        'rural_banks' => $payload['rural_cooperative_banks'] ?? null,
                        'data_type' => $dataType,
                    ]
                );
            }

            $imported++;
        }

        Storage::delete($state['path']);
        session()->forget(self::SESSION_KEY);

        return redirect()
            ->route('imports.region-data')
            ->with('success', "Import complete. Imported {$imported} rows, skipped {$skipped} rows.")
            ->with('warnings', $warnings);
    }

    private function fieldsForType(string $dataType): array
    {
        if ($dataType === 'motor_vehicles') {
            return [
                'province' => ['label' => 'Province', 'required' => true],
                'year' => ['label' => 'Year', 'required' => true],
                'private' => ['label' => 'Private', 'required' => false],
                'for_hire' => ['label' => 'For Hire', 'required' => false],
                'government' => ['label' => 'Government', 'required' => false],
                'diplomatic' => ['label' => 'Diplomatic', 'required' => false],
                'exempt' => ['label' => 'Exempt', 'required' => false],
                'total' => ['label' => 'Total', 'required' => false],
            ];
        }

        return [
            'province' => ['label' => 'Province', 'required' => true],
            'year' => ['label' => 'Year', 'required' => true],
            'universal_commercial_banks' => ['label' => 'Universal/Commercial Banks', 'required' => false],
            'thrift_banks' => ['label' => 'Thrift Banks', 'required' => false],
            'rural_cooperative_banks' => ['label' => 'Rural/Cooperative Banks', 'required' => false],
            'total' => ['label' => 'Total', 'required' => false],
        ];
    }

    private function suggestMapping(array $headers, string $dataType): array
    {
        $map = [];
        $normalized = array_map([$this, 'normalizeHeader'], $headers);
        $lookup = array_combine($normalized, $headers);

        $synonyms = [
            'province' => ['province', 'prov', 'provincearea', 'area'],
            'year' => ['year', 'yr'],
            'private' => ['private', 'priv', 'privatevehicles', 'privvehicles'],
            'for_hire' => ['forhire', 'forhirevehicles', 'hire', 'forhirevehicles'],
            'government' => ['government', 'gov', 'govt', 'governmentvehicles'],
            'diplomatic' => ['diplomatic', 'diplom'],
            'exempt' => ['exempt', 'exemption'],
            'total' => ['total', 'grandtotal', 'overall'],
            'universal_commercial_banks' => ['universalcommercialbanks', 'universalbanks', 'universalandcommercialbanks', 'universalcommercial'],
            'thrift_banks' => ['thriftbanks', 'thrift'],
            'rural_cooperative_banks' => ['ruralcooperativebanks', 'ruralbanks', 'ruralandcooperativebanks', 'ruralcooperative'],
        ];

        foreach ($this->fieldsForType($dataType) as $field => $meta) {
            foreach ($synonyms[$field] ?? [] as $syn) {
                if (isset($lookup[$syn])) {
                    $map[$field] = $lookup[$syn];
                    break;
                }
            }
        }

        return $map;
    }

    private function detectDelimiter(string $path): string
    {
        $sample = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $line = $sample[0] ?? '';
        $delimiters = [',', ';', "\t", '|'];
        $best = ',';
        $max = 0;
        foreach ($delimiters as $delimiter) {
            $count = substr_count($line, $delimiter);
            if ($count > $max) {
                $max = $count;
                $best = $delimiter;
            }
        }
        return $best;
    }

    private function readHeadersAndPreview(string $path, bool $hasHeader, string $delimiter, int $limit): array
    {
        $file = new \SplFileObject($path);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
        $file->setCsvControl($delimiter);

        $headers = [];
        $preview = [];

        foreach ($file as $index => $row) {
            if ($row === [null] || $row === false) {
                continue;
            }
            if ($index === 0 && $hasHeader) {
                $headers = $this->normalizeHeaders($row);
                continue;
            }
            if (!$hasHeader && empty($headers)) {
                $headers = $this->generateHeaders(count($row));
            }
            $preview[] = $row;
            if (count($preview) >= $limit) {
                break;
            }
        }

        return [$headers, $preview];
    }

    private function iterateRows(string $path, bool $hasHeader, string $delimiter): \Generator
    {
        $file = new \SplFileObject($path);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY);
        $file->setCsvControl($delimiter);

        $headers = [];
        foreach ($file as $index => $row) {
            if ($row === [null] || $row === false) {
                continue;
            }
            if ($index === 0 && $hasHeader) {
                $headers = $this->normalizeHeaders($row);
                continue;
            }
            if (!$hasHeader && empty($headers)) {
                $headers = $this->generateHeaders(count($row));
            }

            $rowNumber = $index + 1;
            yield $rowNumber => $this->combineRow($headers, $row);
        }
    }

    private function normalizeHeaders(array $row): array
    {
        return array_map(function ($value) {
            $clean = trim((string) $value);
            return $clean !== '' ? $clean : 'Column';
        }, $row);
    }

    private function generateHeaders(int $count): array
    {
        $headers = [];
        for ($i = 1; $i <= $count; $i++) {
            $headers[] = "Column {$i}";
        }
        return $headers;
    }

    private function combineRow(array $headers, array $row): array
    {
        $data = [];
        foreach ($headers as $i => $header) {
            $data[$header] = $row[$i] ?? null;
        }
        return $data;
    }

    private function mapRow(array $row, array $mapping): array
    {
        $data = [];
        foreach ($mapping as $field => $column) {
            if (!$column) {
                continue;
            }
            $data[$field] = $row[$column] ?? null;
        }
        return $data;
    }

    private function sanitizeRow(array $data, array $fields): array
    {
        foreach ($fields as $field => $meta) {
            if (!isset($data[$field])) {
                continue;
            }
            if (is_string($data[$field])) {
                $data[$field] = str_replace([',', ' '], '', $data[$field]);
            }
            if (in_array($field, ['province'], true)) {
                $data[$field] = trim((string) $data[$field]);
            }
            if (in_array($field, ['year'], true)) {
                $data[$field] = (int) $data[$field];
            }
            if ($field !== 'province' && $field !== 'year') {
                $data[$field] = $data[$field] === '' ? null : (float) $data[$field];
            }
        }
        return $data;
    }

    private function provinceMap(int $regionId): array
    {
        $names = $this->regionThreeProvinces();
        $map = [];
        foreach ($names as $name) {
            $province = Province::firstOrCreate(
                ['name' => $name],
                ['region_id' => $regionId]
            );
            $map[strtolower($name)] = $province->id;
        }
        return $map;
    }

    private function regionThreeProvinces(): array
    {
        return [
            'Aurora',
            'Bataan',
            'Bulacan',
            'Nueva Ecija',
            'Pampanga',
            'Tarlac',
            'Zambales',
        ];
    }

    private function normalizeProvince(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $clean = strtolower(trim($value));
        $clean = preg_replace('/\\s+/', ' ', $clean);
        if (in_array($clean, ['region iii', 'region 3', 'regioniii', 'region iii total'], true)) {
            return 'region iii';
        }
        return $clean;
    }

    private function normalizeHeader(string $value): string
    {
        $clean = strtolower(trim($value));
        return preg_replace('/[^a-z0-9]/', '', $clean);
    }
}
