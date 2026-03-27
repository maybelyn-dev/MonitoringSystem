@extends('layouts.app')

@section('content')
<div class="min-h-full space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($metrics as $card)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <span class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ $card['label'] }}</span>
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                </div>
                <div class="mt-4 text-2xl font-semibold text-slate-900">{{ $card['value'] }}</div>
                <div class="mt-2 text-sm font-semibold text-emerald-600">{{ $card['trend'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Performance</p>
                <h2 class="text-lg font-semibold text-slate-900">Performance Wavy Chart</h2>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold hover:bg-slate-200 transition">Monthly</button>
                <button class="px-4 py-2 rounded-full bg-blue-600 text-white text-xs font-semibold shadow-sm">Yearly</button>
            </div>
        </div>
        <div class="h-[300px]">
            <canvas id="wavyChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const peso = '{!! '₱' !!}';
    const bankingLabels = @json($bankingTrend->pluck('year')->values());
    const bankingLiabilities = @json($bankingTrend->pluck('banking_liabilities')->values()).map(Number);

    const incomeByYear = @json($incomeTrend->keyBy('year')->map->operating_income);
    const incomeSeries = bankingLabels.map((y) => (incomeByYear && incomeByYear[y]) ? Number(incomeByYear[y]) : null);

    const wavyCtx = document.getElementById('wavyChart').getContext('2d');
    new Chart(wavyCtx, {
        type: 'line',
        data: {
            labels: bankingLabels,
            datasets: [
                {
                    label: `Banking Liabilities (${peso})`,
                    data: bankingLiabilities,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.06)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                },
                {
                    label: `Operating Income (${peso})`,
                    data: incomeSeries,
                    spanGaps: true,
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.06)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d9488',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 12,
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#64748b'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.parsed?.y ?? context.parsed ?? 0;
                            const formatted = new Intl.NumberFormat('en-PH', { maximumFractionDigits: 1 }).format(value);
                            return `${context.dataset.label}: ${peso}${formatted}B`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, family: "'Inter', sans-serif" },
                        color: '#94a3b8'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#64748b'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
