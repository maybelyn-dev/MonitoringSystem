<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectImportController extends Controller
{
    private const SESSION_KEY = 'project_import';

    public function showUpload()
    {
        return view('pages.imports.projects.upload');
    }

    public function handleUpload(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
            'has_header' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('csv_file')->store('imports');
        $delimiter = $this->detectDelimiter(Storage::path($path));
        $hasHeader = (bool) ($validated['has_header'] ?? true);

        [$headers, $previewRows] = $this->readHeadersAndPreview(Storage::path($path), $hasHeader, $delimiter, 8);

        session()->put(self::SESSION_KEY, [
            'path' => $path,
            'has_header' => $hasHeader,
            'delimiter' => $delimiter,
            'headers' => $headers,
        ]);

        return redirect()
            ->route('imports.projects.mapping')
            ->with('preview_rows', $previewRows);
    }

    public function showMapping(Request $request)
    {
        $state = session()->get(self::SESSION_KEY);
        if (!$state) {
            return redirect()->route('imports.projects')->withErrors(['csv_file' => 'Please upload a CSV file first.']);
        }

        $fields = $this->projectFields();
        $headers = $state['headers'];
        $previewRows = session()->get('preview_rows', []);

        return view('pages.imports.projects.mapping', compact('fields', 'headers', 'previewRows'));
    }

    public function import(Request $request)
    {
        $state = session()->get(self::SESSION_KEY);
        if (!$state) {
            return redirect()->route('imports.projects')->withErrors(['csv_file' => 'Please upload a CSV file first.']);
        }

        $fields = $this->projectFields();
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
            'skip_duplicates' => ['nullable', 'boolean'],
        ]));

        $mapping = $validated['mapping'] ?? [];
        $skipDuplicates = (bool) ($validated['skip_duplicates'] ?? false);

        $imported = 0;
        $skipped = 0;
        $errors = [];

        $filePath = Storage::path($state['path']);
        $rows = $this->iterateRows($filePath, $state['has_header'], $state['delimiter']);

        $user = Auth::user();
        foreach ($rows as $rowNumber => $row) {
            $data = $this->mapRow($row, $mapping);

            if (!$user->isAdmin()) {
                $data['agency_id'] = $user->agency_id;
            }

            if ($this->rowIsEmpty($data)) {
                $skipped++;
                continue;
            }

            $validator = Validator::make($data, $this->rowValidationRules($fields, $data));
            if ($validator->fails()) {
                $errors[] = [
                    'row' => $rowNumber,
                    'messages' => $validator->errors()->all(),
                ];
                $skipped++;
                continue;
            }

            if ($skipDuplicates && $this->isDuplicate($data)) {
                $skipped++;
                continue;
            }

            Project::create($data);
            $imported++;
        }

        Storage::delete($state['path']);
        session()->forget(self::SESSION_KEY);

        return redirect()
            ->route('imports.projects')
            ->with('success', "Import complete. Imported {$imported} rows, skipped {$skipped} rows.")
            ->with('import_errors', $errors);
    }

    private function projectFields(): array
    {
        return [
            'name' => ['label' => 'Project Name', 'required' => true, 'rules' => ['required', 'string', 'max:255']],
            'description' => ['label' => 'Description', 'required' => false, 'rules' => ['nullable', 'string']],
            'budget' => ['label' => 'Budget', 'required' => false, 'rules' => ['nullable', 'numeric', 'min:0']],
            'status' => ['label' => 'Status', 'required' => false, 'rules' => ['nullable', 'in:Planning,In Progress,Completed,On Hold,Cancelled']],
            'start_date' => ['label' => 'Start Date', 'required' => false, 'rules' => ['nullable', 'date']],
            'end_date' => ['label' => 'End Date', 'required' => false, 'rules' => ['nullable', 'date', 'after_or_equal:start_date']],
            'progress' => ['label' => 'Progress (%)', 'required' => false, 'rules' => ['nullable', 'integer', 'min:0', 'max:100']],
            'agency_id' => ['label' => 'Agency ID', 'required' => false, 'rules' => ['nullable', 'integer', 'exists:agencies,id']],
        ];
    }

    private function rowValidationRules(array $fields, array $data): array
    {
        $rules = [];
        foreach ($fields as $field => $meta) {
            $rules[$field] = $meta['rules'];
        }

        // If a non-admin is importing, we force agency_id, so drop validation if null.
        if (empty($data['agency_id'])) {
            $rules['agency_id'] = ['nullable'];
        }

        return $rules;
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

            $rowNumber = $hasHeader ? $index + 1 : $index + 1;
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

    private function rowIsEmpty(array $data): bool
    {
        foreach ($data as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }
        return true;
    }

    private function isDuplicate(array $data): bool
    {
        $query = Project::query();
        if (!empty($data['name'])) {
            $query->where('name', $data['name']);
        }
        if (!empty($data['agency_id'])) {
            $query->where('agency_id', $data['agency_id']);
        }
        return $query->exists();
    }
}
