@extends('layouts.app')

@section('title', 'Province Monitoring Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-4">
    <div class="bg-white border border-blue-100 rounded-xl p-4 shadow-sm">
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
            <div class="text-xs text-slate-500">
                Total Records: <span class="font-semibold text-slate-700">{{ $stats->count() }}</span>
            </div>
        </div>
    </div>

    @if($isEmpty)
        <div class="rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm text-blue-700">
            No records found for this province. Please verify the province selection and re-run the seeder if needed.
        </div>
    @else
        <div class="rounded-lg border border-blue-100 bg-white p-4 shadow-sm">
            <div class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-3">Province Snapshot</div>
            <div class="overflow-auto">
                <table class="min-w-full text-xs text-slate-700">
                    <thead class="text-[11px] uppercase tracking-widest text-blue-500 border-b border-blue-50">
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
                    <p class="text-[11px] uppercase tracking-widest text-blue-600 font-semibold">Vehicles</p>
                    <h2 class="text-sm font-bold text-slate-900">Private vs For Hire Comparison</h2>
                </div>
                <div class="text-[11px] text-slate-500">
                    Year: <span class="font-semibold text-slate-700">{{ $latestVehicleYear ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="h-[220px]">
                <canvas id="provinceVehicleChart"></canvas>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const labels = @json($chartLabels);
    const values = @json($chartValues);
    const peso = '{!! '₱' !!}';

    const ctx = document.getElementById('provinceVehicleChart');
    if (ctx && labels.length) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Vehicles',
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
                        max: 350000,
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
