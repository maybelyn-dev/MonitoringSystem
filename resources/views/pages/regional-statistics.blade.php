@extends('layouts.app')

@section('title', 'Province Monitoring Dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-3 py-4 space-y-3">
    <div class="bg-white border border-blue-100 rounded-xl p-3 shadow-sm">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] uppercase tracking-[0.2em] text-blue-600 font-semibold">
                    {{ $isPublic ? 'Public Viewing Mode' : 'Region III Monitoring System' }}
                </p>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Province Dashboard</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Province: <span class="font-semibold text-slate-700">{{ $selectedProvince ?? 'Region III (Global)' }}</span>
                </p>
            </div>
            <div class="text-[11px] text-slate-500">
                {{ $totalRecordsLabel ?? 'Total Records' }}:
                <span class="font-semibold text-slate-700">{{ $totalRecordsValue ?? $stats->count() }}</span>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center gap-2 text-[11px]">
            <a href="{{ $isPublic ? route('stats.public', ['province_id' => $selectedProvinceId, 'table' => '13.1']) : route('regional-statistics', ['province_id' => $selectedProvinceId, 'table' => '13.1']) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '13.1' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-700 border-blue-200' }}">
                Motor Vehicles
            </a>
            <a href="{{ $isPublic ? route('stats.public', ['province_id' => $selectedProvinceId, 'table' => '16.2']) : route('regional-statistics', ['province_id' => $selectedProvinceId, 'table' => '16.2']) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '16.2' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-700 border-blue-200' }}">
                Banking Deposits
            </a>
            <a href="{{ $isPublic ? route('stats.public', ['province_id' => $selectedProvinceId, 'table' => '16.3']) : route('regional-statistics', ['province_id' => $selectedProvinceId, 'table' => '16.3']) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '16.3' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-700 border-blue-200' }}">
                Banking Income
            </a>
        </div>
    </div>

    <div class="rounded-lg border border-blue-100 bg-white p-3 shadow-sm">
            <div class="text-[11px] font-semibold uppercase tracking-widest text-blue-600 mb-2">Province Snapshot</div>
            <div class="overflow-auto">
                <table class="min-w-full text-[11px] text-slate-700">
                    <thead class="text-[10px] uppercase tracking-widest text-blue-500 border-b border-blue-50">
                        <tr>
                            <th class="text-left py-2 pr-3 font-semibold">Province</th>
                            <th class="text-right py-2 pr-3 font-semibold">Banking Total</th>
                            <th class="text-right py-2 font-semibold">Yearly Stats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100 last:border-b-0">
                            <td class="py-2 pr-3 font-medium text-slate-900">{{ $selectedProvince ?? 'N/A' }}</td>
                            <td class="py-2 pr-3 text-right text-slate-900">
                                @if($bankingTotalValue === null)
                                    —
                                @else
                                    {!! '₱' !!} {{ number_format($bankingTotalValue, 2) }}B
                                    <span class="text-[10px] text-slate-400">({{ $latestBankingYear }})</span>
                                @endif
                            </td>
                            <td class="py-2 text-right text-slate-900">
                                @if($latestVehicleYear === null)
                                    —
                                @else
                                    <span class="font-semibold">{{ number_format($privateValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-400">Private</span>
                                    <span class="mx-1 text-slate-300">|</span>
                                    <span class="font-semibold">{{ number_format($forHireValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-400">For Hire</span>
                                    <span class="mx-1 text-slate-300">|</span>
                                    <span class="font-semibold">{{ number_format($governmentValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-400">Government</span>
                                    <span class="text-[10px] text-slate-400">({{ $latestVehicleYear }})</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>

    <div class="rounded-lg border border-blue-100 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-blue-600 font-semibold">
                        {{ ($selectedTable ?? '13.1') === '13.1' ? 'Vehicles' : 'Banking' }}
                    </p>
                    <h2 class="text-[13px] font-bold text-slate-900">
                        {{ ($selectedTable ?? '13.1') === '13.1' ? 'Private vs For Hire Comparison' : 'Institution Type Breakdown' }}
                    </h2>
                </div>
                <div class="text-[10px] text-slate-500">
                    Year: <span class="font-semibold text-slate-700">{{ $latestVehicleYear ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="h-[190px]">
                <canvas id="provinceVehicleChart"></canvas>
            </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const labels = @json($chartLabels);
    const values = @json($chartValues);
    const peso = '{!! '₱' !!}';
    const selectedTable = @json($selectedTable ?? '13.1');

    const ctx = document.getElementById('provinceVehicleChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: selectedTable === '13.1' ? 'Vehicles' : 'Banking',
                    data: values,
                    backgroundColor: ['#1D4ED8', '#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE'],
                    borderColor: ['#1D4ED8', '#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE'],
                    borderWidth: 1,
                    borderRadius: 6,
                    minBarLength: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = context.parsed?.y ?? context.parsed ?? 0;
                                const formatted = new Intl.NumberFormat('en-PH', { maximumFractionDigits: 0 }).format(value);
                                return `${context.dataset.label}: ${peso}${formatted}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        min: 0,
                        max: selectedTable === '13.1' ? 350000 : undefined,
                        ticks: {
                            color: '#64748b',
                            font: { size: 10 },
                            callback: (value) => new Intl.NumberFormat('en-PH').format(value)
                        },
                        grid: { color: 'rgba(148, 163, 184, 0.2)' }
                    },
                    x: {
                        ticks: { color: '#64748b', font: { size: 10 } },
                        grid: { display: false }
                    }
                }
            }
        });
    }
</script>
@endpush
