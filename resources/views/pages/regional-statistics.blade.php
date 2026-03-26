@extends('layouts.app')

@section('title', 'Province Monitoring Dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-3 py-4 space-y-4">
    <div class="bg-[#111111] border border-white/10 rounded-3xl p-4 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500 font-semibold">Region III Monitoring System</p>
                <h1 class="text-lg sm:text-xl font-bold text-white">Province Dashboard</h1>
                <p class="text-[11px] text-slate-500 mt-1">
                    Province: <span class="font-semibold text-slate-200">{{ $selectedProvince ?? 'Not set' }}</span>
                </p>
            </div>
            <div class="text-[11px] text-slate-500">
                {{ $totalRecordsLabel ?? 'Total Records' }}:
                <span class="font-semibold text-slate-200">{{ $totalRecordsValue ?? $stats->count() }}</span>
            </div>
        </div>
        <div class="mt-3 flex flex-wrap items-center gap-2 text-[11px]">
            <a href="{{ route('regional-statistics', ['province' => $selectedProvince, 'table' => '13.1', 'year' => $selectedYear]) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '13.1' ? 'bg-[#00FFA3]/10 text-[#00FFA3] border-[#00FFA3]/40' : 'bg-[#0F0F0F] text-slate-300 border-white/10 hover:border-[#00FFA3]/40' }}">
                Motor Vehicles
            </a>
            <a href="{{ route('regional-statistics', ['province' => $selectedProvince, 'table' => '16.2', 'year' => $selectedYear]) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '16.2' ? 'bg-[#00FFA3]/10 text-[#00FFA3] border-[#00FFA3]/40' : 'bg-[#0F0F0F] text-slate-300 border-white/10 hover:border-[#00FFA3]/40' }}">
                Banking Deposits
            </a>
            <a href="{{ route('regional-statistics', ['province' => $selectedProvince, 'table' => '16.3', 'year' => $selectedYear]) }}"
               class="px-3 py-1.5 rounded-lg border {{ ($selectedTable ?? '13.1') === '16.3' ? 'bg-[#00FFA3]/10 text-[#00FFA3] border-[#00FFA3]/40' : 'bg-[#0F0F0F] text-slate-300 border-white/10 hover:border-[#00FFA3]/40' }}">
                Banking Income
            </a>
            <form action="{{ route('regional-statistics') }}" method="GET" class="flex items-center gap-2 ml-auto">
                <input type="hidden" name="province" value="{{ $selectedProvince }}">
                <input type="hidden" name="table" value="{{ $selectedTable }}">
                <label class="text-[10px] uppercase tracking-widest text-slate-500 font-semibold">Year</label>
                <select name="year" onchange="this.form.submit()"
                        class="bg-[#0F0F0F] text-slate-200 text-[11px] font-semibold rounded-lg px-2 py-1 border border-white/10 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ (int) $selectedYear === (int) $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-[#111111] p-4 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <div class="text-[11px] font-semibold uppercase tracking-widest text-slate-400 mb-2">Province Snapshot</div>
            <div class="overflow-auto">
                <table class="min-w-full text-[11px] text-slate-300">
                    <thead class="text-[10px] uppercase tracking-widest text-slate-500 border-b border-white/10">
                        <tr>
                            <th class="text-left py-2 pr-3 font-semibold">Province</th>
                            <th class="text-right py-2 pr-3 font-semibold">Banking Total</th>
                            <th class="text-right py-2 font-semibold">Yearly Stats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-white/10 last:border-b-0">
                            <td class="py-2 pr-3 font-medium text-slate-100">{{ $selectedProvince ?? 'N/A' }}</td>
                            <td class="py-2 pr-3 text-right text-slate-100">
                                @if($bankingTotalValue === null)
                                    —
                                @else
                                    &#8369; {{ number_format($bankingTotalValue, 2) }}B
                                    <span class="text-[10px] text-slate-500">({{ $latestBankingYear }})</span>
                                @endif
                            </td>
                            <td class="py-2 text-right text-slate-100">
                                @if($latestVehicleYear === null)
                                    —
                                @else
                                    <span class="font-semibold">{{ number_format($privateValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-500">Private</span>
                                    <span class="mx-1 text-slate-600">|</span>
                                    <span class="font-semibold">{{ number_format($forHireValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-500">For Hire</span>
                                    <span class="mx-1 text-slate-600">|</span>
                                    <span class="font-semibold">{{ number_format($governmentValue, 0) }}</span>
                                    <span class="text-[10px] text-slate-500">Government</span>
                                    <span class="text-[10px] text-slate-500">({{ $latestVehicleYear }})</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-[#111111] p-4 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-semibold">
                        {{ ($selectedTable ?? '13.1') === '13.1' ? 'Vehicles' : 'Banking' }}
                    </p>
                    <h2 class="text-[13px] font-bold text-white">
                        {{ ($selectedTable ?? '13.1') === '13.1' ? 'Private vs For Hire Comparison' : 'Institution Type Breakdown' }}
                    </h2>
                </div>
                <div class="text-[10px] text-slate-500">
                    Year: <span class="font-semibold text-slate-200">{{ $selectedYear ?? 'N/A' }}</span>
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
    const peso = '\u20B1';
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
                    backgroundColor: ['#00FFA3', '#FFFFFF', '#00D1FF', '#7C5CFF', '#00FFA3'],
                    borderColor: ['#00FFA3', '#FFFFFF', '#00D1FF', '#7C5CFF', '#00FFA3'],
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
                            color: '#94a3b8',
                            font: { size: 10 },
                            callback: (value) => new Intl.NumberFormat('en-PH').format(value)
                        },
                        grid: { color: 'rgba(255, 255, 255, 0.06)' }
                    },
                    x: {
                        ticks: { color: '#94a3b8', font: { size: 10 } },
                        grid: { color: 'rgba(255, 255, 255, 0.04)' }
                    }
                }
            }
        });
    }
</script>
@endpush
