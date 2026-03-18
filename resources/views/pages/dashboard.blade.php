@extends('layouts.app')

@section('content')
<div class="min-h-full space-y-3">
    <!-- Welcome Header Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl px-7 py-5 text-white shadow-md shadow-slate-900/10 mb-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl md:text-3xl leading-[1.05] tracking-tight font-black mb-1">Region 3 Monitoring Portal</h1>
                <p class="text-sm text-blue-100">Real-time economic and administrative data for Central Luzon</p>
            </div>
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                <label class="text-[11px] uppercase tracking-widest text-blue-100 font-semibold">Province</label>
                <select name="province_id" onchange="this.form.submit()"
                        class="bg-white text-slate-700 text-xs font-semibold rounded-lg px-3 py-2 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">Region III</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ (string) $selectedProvinceId === (string) $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    @if(!empty($provinceDataStatus))
        <div class="rounded-lg border border-blue-100 bg-blue-50 px-3 py-2 text-[11px] text-blue-700">
            {{ $provinceDataStatus }}
        </div>
    @endif

    <!-- Top Stats - Auto-Fit Grid -->
    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 items-stretch">
            @foreach($metrics as $metric)
            <div class="w-full flex-grow bg-white rounded-2xl p-3 shadow-sm border border-blue-100 hover:shadow-md transition flex flex-col h-full">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">{{ $metric['label'] }}</span>
                    <div class="w-6 h-6 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-[10px]">
                        <i class="fas {{ $metric['icon'] }}"></i>
                    </div>
                </div>
                <p class="text-lg font-black text-slate-800 leading-none">{{ $metric['value'] }}</p>
                <p class="text-[10px] text-slate-500 font-bold mt-1">{{ $metric['subtitle'] }}</p>
                <p class="text-[10px] text-emerald-600 font-bold mt-1.5">{{ $metric['trend'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-3">
        <!-- Large Wavy Chart -->
        <div class="w-full bg-white rounded-xl p-3 shadow-sm border border-blue-100 flex flex-col">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-2 shrink-0">
                <div>
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Performance</p>
                    <h2 class="text-base md:text-lg font-black text-slate-800">Wavy Chart</h2>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 md:px-3.5 py-1.5 bg-blue-600 text-white rounded-xl text-[11px] font-bold hover:bg-blue-700 transition whitespace-nowrap">Monthly</button>
                    <button class="px-3 md:px-3.5 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-[11px] font-bold hover:bg-blue-100 transition whitespace-nowrap">Yearly</button>
                </div>
            </div>
            <div class="flex-1 h-[180px] max-h-[180px]">
                <div class="relative w-full h-full">
                    <canvas id="wavyChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <!-- Doughnut Chart -->
        <div class="bg-white rounded-xl p-3 shadow-sm border border-blue-100">
            <div class="mb-2">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest">Earnings</p>
                <h3 class="text-base md:text-lg font-black text-slate-800">Doughnut Chart</h3>
            </div>
            <div class="relative w-full h-[180px] max-h-[180px]">
                <canvas id="doughnutChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        <!-- Stacked Bar Chart -->
        <div class="bg-white rounded-2xl p-3 shadow-sm border border-blue-100">
            <div class="flex flex-col gap-2">
                <div>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em]">CONVERSIONS</p>
                    <h3 class="text-base md:text-lg font-black text-slate-800">Weekly Conversions</h3>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold text-slate-500">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-900"></span>
                        <span>Completed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-300"></span>
                        <span>Failed</span>
                    </div>
                </div>
            </div>
            <div class="relative w-full h-[190px] max-h-[190px] mt-3">
                <canvas id="stackedBarChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Province Overview Table -->
    <div class="grid grid-cols-1 gap-3">
        <!-- Province Overview Table -->
        <div class="bg-white rounded-xl p-3 shadow-sm border border-blue-100 max-h-[260px] overflow-hidden flex flex-col">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-2">
                <h3 class="font-black text-slate-800 text-sm md:text-base">Province Highlights</h3>
                <span class="text-blue-600 text-[10px] font-bold whitespace-nowrap">Region III</span>
            </div>
            <div class="overflow-auto max-h-[220px]">
                <table class="min-w-max w-full text-left text-[11px] md:text-xs">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-100 bg-white sticky top-0">
                            <th class="pb-2 px-3 font-bold">Province</th>
                            <th class="pb-2 px-3 font-bold">Budget</th>
                            <th class="pb-2 px-3 font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @php
                            $projects = [
                                ['province' => 'Aurora', 'budget' => 14123, 'status' => 'Updated'],
                                ['province' => 'Bataan', 'budget' => 65063, 'status' => 'Updated'],
                                ['province' => 'Bulacan', 'budget' => 317678, 'status' => 'Updated'],
                            ];
                        @endphp
                        @foreach($projects as $project)
                        <tr class="border-b border-slate-50 hover:bg-blue-50/30 transition">
                            <td class="py-1 px-2 font-bold text-slate-800">{{ $project['province'] }}</td>
                            <td class="py-1 px-2 text-slate-600">{!! '₱' !!} {{ number_format($project['budget'], 0) }}</td>
                            <td class="py-1 px-2">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[9px] font-black uppercase inline-block whitespace-nowrap">
                                    {{ $project['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

    const bankingDistribution = @json($bankingDistribution);
    const doughnutData = [
        Number(bankingDistribution['Universal Banks'] ?? 0),
        Number(bankingDistribution['Thrift Banks'] ?? 0),
        Number(bankingDistribution['Rural Banks'] ?? 0),
    ];

    const weeklyLabels = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
    const weeklyCompleted = [34, 28, 40, 36, 44, 26, 38];
    const weeklyPending = [14, 10, 16, 12, 18, 9, 13];
    const weeklyFailed = [6, 5, 7, 4, 6, 3, 5];
    // Banking Liabilities Trend Chart (2011-2020)
    const wavyCtx = document.getElementById('wavyChart').getContext('2d');
    const wavyChart = new Chart(wavyCtx, {
        type: 'line',
        data: {
            labels: bankingLabels,
            datasets: [
                {
                    label: `Banking Liabilities (${peso})`,
                    data: bankingLiabilities,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                },
                {
                    label: `Operating Income (${peso})`,
                    data: incomeSeries,
                    spanGaps: true,
                    borderColor: '#22d3ee',
                    backgroundColor: 'rgba(34, 211, 238, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#22d3ee',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { top: 8, right: 12, bottom: 8, left: 12 }
            },
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
                },
                filler: {
                    propagate: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.5)',
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

    // Banking Institutions Distribution (2020)
    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Universal Banks', 'Thrift Banks', 'Rural Banks'],
            datasets: [{
                data: doughnutData,
                backgroundColor: [
                    '#2563eb',
                    '#22d3ee',
                    '#3b82f6'
                ],
                borderColor: '#fff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#64748b'
                    }
                }
            }
        }
    });

    // Weekly Conversions (Stacked)
    const stackedBarCtx = document.getElementById('stackedBarChart').getContext('2d');
    const stackedBarChart = new Chart(stackedBarCtx, {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [
                {
                    label: 'Completed',
                    data: weeklyCompleted,
                    backgroundColor: '#1e3a8a'
                },
                {
                    label: 'Pending',
                    data: weeklyPending,
                    backgroundColor: '#2563eb'
                },
                {
                    label: 'Failed',
                    data: weeklyFailed,
                    backgroundColor: '#93c5fd'
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x',
            layout: {
                padding: { top: 6, right: 8, bottom: 4, left: 6 }
            },
            scales: {
                x: {
                    stacked: true,
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#64748b'
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.25)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, family: "'Inter', sans-serif" },
                        color: '#94a3b8'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            datasets: {
                bar: {
                    categoryPercentage: 0.65,
                    barPercentage: 0.8
                }
            }
        }
    });
</script>
@endpush
@endsection
