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
                    @php
                        $provinceOptions = $provinces->unique('name')->values();
                    @endphp
                    @foreach($provinceOptions as $province)
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
        <!-- Regional Performance Trends -->
        <div class="w-full bg-white rounded-xl p-3 shadow-sm border border-blue-100 flex flex-col">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 mb-1.5 shrink-0">
                <div>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Performance</p>
                    <h2 class="text-sm md:text-base font-black text-slate-800">Regional Performance Trends</h2>
                </div>
            </div>
            <div class="flex-1 h-[360px] max-h-[360px]">
                <div class="relative w-full h-full">
                    <canvas id="wavyChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <!-- Banking Type Distribution -->
        <div class="bg-white rounded-xl p-3 shadow-sm border border-blue-100 h-[300px] flex flex-col overflow-visible">
            <div class="mb-2">
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Earnings</p>
                <h3 class="text-sm md:text-base font-black text-slate-800">Banking Type Distribution</h3>
            </div>
            <div class="relative w-full flex-1 h-[280px]">
                <canvas id="doughnutChart" class="absolute inset-0 w-full h-full block"></canvas>
            </div>
        </div>

        <!-- Daily System Activity -->
        <div class="bg-white rounded-2xl p-3 shadow-sm border border-blue-100 h-[300px] flex flex-col">
            <div class="flex flex-col gap-2">
                <div>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.2em]">SYSTEM</p>
                    <h3 class="text-sm md:text-base font-black text-slate-800">Daily System Activity</h3>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-[10px] font-bold text-slate-500">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-900"></span>
                        <span>Private</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>For Hire</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-300"></span>
                        <span>Government</span>
                    </div>
                </div>
            </div>
            <div class="relative w-full flex-1 min-h-[200px] mt-2 px-1">
                <canvas id="stackedBarChart" class="absolute inset-0 w-full h-full block"></canvas>
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
    const trendLabels = @json($trendLabels);
    const trendValues = @json($trendValues).map(Number);
    const trendUnitLabel = @json($trendUnitLabel);
    const selectedTable = @json($selectedTable ?? '13.1');

    const bankingDistribution = @json($bankingDistribution);
    let doughnutData = [
        Number(bankingDistribution['Universal Banks'] ?? 0),
        Number(bankingDistribution['Thrift Banks'] ?? 0),
        Number(bankingDistribution['Rural Banks'] ?? 0),
    ];
    const hasDoughnutData = doughnutData.some((value) => value > 0);
    if (!hasDoughnutData) {
        doughnutData = [714.6, 57.3, 35.3];
    }

    const weeklyLabels = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
    const weeklyPrivate = [48, 55, 51, 60, 58, 44, 47];
    const weeklyForHire = [12, 15, 14, 18, 17, 11, 13];
    const weeklyGovernment = [5, 6, 4, 7, 6, 3, 4];
    // Regional Performance Trend Chart (Yearly)
    const wavyCtx = document.getElementById('wavyChart').getContext('2d');
    const wavyChart = new Chart(wavyCtx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [
                {
                    label: selectedTable === '13.1' ? 'Motor Vehicles' : 'Banking Total',
                    data: trendValues,
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
                            return selectedTable === '13.1'
                                ? `${context.dataset.label}: ${formatted}`
                                : `${context.dataset.label}: ${peso}${formatted}B`;
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
                        title: {
                            display: true,
                            text: selectedTable === '13.1' ? 'Units' : 'Billion Pesos',
                            color: '#64748b',
                            font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" }
                        },
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

    // Banking Type Distribution (Selected Year)
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
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const total = doughnutData.reduce((sum, val) => sum + val, 0) || 1;
                            const value = context.parsed ?? 0;
                            const percent = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percent}%)`;
                        }
                    }
                }
            }
        }
    });
    doughnutChart.resize();

    // Daily System Activity (Simulated)
    const stackedBarCtx = document.getElementById('stackedBarChart').getContext('2d');
    const stackedBarChart = new Chart(stackedBarCtx, {
        type: 'bar',
        data: {
            labels: weeklyLabels,
            datasets: [
                {
                    label: 'Private',
                    data: weeklyPrivate,
                    backgroundColor: '#1e3a8a'
                },
                {
                    label: 'For Hire',
                    data: weeklyForHire,
                    backgroundColor: '#2563eb'
                },
                {
                    label: 'Government',
                    data: weeklyGovernment,
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
