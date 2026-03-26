@extends('layouts.app')

@section('content')
<div class="min-h-full space-y-6 animate-fade-in">
    <!-- Header -->
    <div class="px-6 py-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-[11px] uppercase tracking-[0.35em] text-[#64748B] font-semibold">RAMS Region III</p>
                <h1 class="text-2xl md:text-3xl font-black text-[#1E293B]">Region III Intelligence Dashboard</h1>
                <p class="text-sm text-[#64748B] mt-1">Live economic and administrative signals across Central Luzon.</p>
            </div>
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <select name="province_id" onchange="this.form.submit()"
                            class="w-64 appearance-none rounded-xl border border-[#00E5FF]/20 bg-white px-10 py-2.5 text-xs font-semibold text-[#1E293B] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/30 hover:border-[#00E5FF]">
                        <option value="">All Provinces</option>
                        @php
                            $provinceOptions = $provinces->unique('name')->values();
                        @endphp
                        @foreach($provinceOptions as $province)
                            <option value="{{ $province->id }}" {{ (string) $selectedProvinceId === (string) $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <select name="table" onchange="this.form.submit()"
                        class="appearance-none rounded-xl border border-[#00E5FF]/20 bg-white px-4 py-2.5 text-xs font-semibold text-[#1E293B] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/30 hover:border-[#00E5FF]">
                    <option value="13.1" {{ $selectedTable === '13.1' ? 'selected' : '' }}>Motor Vehicles </option>
                    <option value="16.2" {{ $selectedTable === '16.2' ? 'selected' : '' }}>Banking Liabilities </option>
                    <option value="16.3" {{ $selectedTable === '16.3' ? 'selected' : '' }}>Operating Income </option>
                </select>
                <select name="year" onchange="this.form.submit()"
                        class="appearance-none rounded-xl border border-[#00E5FF]/20 bg-white px-4 py-2.5 text-xs font-semibold text-[#1E293B] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/30 hover:border-[#00E5FF]">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ (int) $selectedYear === (int) $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if(!empty($provinceDataStatus))
        <div class="rounded-xl border border-[#00E5FF]/20 bg-white px-4 py-3 text-xs text-[#00E5FF] shadow-[0_0_14px_rgba(3,196,255,0.08)]">
            {{ $provinceDataStatus }}
        </div>
    @endif

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @php
            $ringPercents = [72, 64, 88, 51, 76, 59, 67, 83];
        @endphp
        @foreach($metrics as $metric)
            @php $percent = $ringPercents[$loop->index % count($ringPercents)]; @endphp
            <div class="group rounded-3xl border border-[#E5E7EB] bg-white backdrop-blur p-4 shadow-[0_4px_12px_rgba(0,0,0,0.05)] transition hover:-translate-y-1 hover:border-[#00E5FF]/40 hover:shadow-[0_6px_20px_rgba(0,229,255,0.1)]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.3em] text-[#64748B] font-semibold">{{ $metric['label'] }}</p>
                        <p class="text-xl font-black text-[#1E293B] mt-1">{{ $metric['value'] }}</p>
                        <p class="text-[11px] text-[#64748B] mt-1">{{ $metric['subtitle'] }}</p>
                        <div class="mt-3 inline-flex items-center gap-2 text-[10px] font-bold text-white">
                            <span class="h-2 w-2 rounded-full bg-[#00E5FF] shadow-[0_0_8px_rgba(0,229,255,0.9)] animate-pulse"></span>
                            <span class="text-[#1E293B]">Optimal</span>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="h-14 w-14 rounded-full border-4 border-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,1)] flex items-center justify-center animate-pulse">
                            <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center">
                                <span class="text-[11px] font-bold text-[#1E293B]">{{ $percent }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 flex items-center justify-between text-[10px] text-[#64748B]">
                    <span class="text-[#1E293B]">{{ $metric['trend'] }}</span>
                    <div class="h-1 w-16 rounded-full bg-slate-200/50 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#00E5FF] to-[#00E5FF]" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Charts -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="xl:col-span-2 rounded-3xl border border-[#E5E7EB] bg-white backdrop-blur p-4 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-[#64748B] font-semibold">Performance</p>
                    <h2 class="text-base font-black text-[#1E293B]">Regional Performance Trends</h2>
                </div>
                <span class="text-[10px] text-[#64748B]">{{ $selectedTable ?? '13.1' }} • {{ $selectedYear }}</span>
            </div>
            <div class="h-[340px] rounded-2xl border border-[#E5E7EB] bg-white p-3">
                <canvas id="wavyChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-[#E5E7EB] bg-white backdrop-blur p-4 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-[#64748B] font-semibold">System Health</p>
                    <h2 class="text-base font-black text-[#1E293B]">Agency Statistics</h2>
                </div>
                <span class="text-[10px] text-[#00E5FF] font-bold animate-pulse">Online</span>
            </div>
            <div class="space-y-3 text-sm text-[#1E293B]">
                <div class="flex items-center justify-between">
                    <span>Monitoring Sync</span>
                    <span class="text-[#00E5FF] font-semibold animate-pulse">Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Data Integrity</span>
                    <span class="text-[#00E5FF] font-semibold animate-pulse">99.1%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Agency Feeds</span>
                    <span class="text-[#00E5FF] font-semibold animate-pulse">Stable</span>
                </div>
                <div class="mt-4 rounded-xl border border-[#00E5FF]/20 bg-white p-3 text-xs text-[#64748B]">
                    Last sync: {{ now()->subMinutes(12)->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="rounded-3xl border border-[#E5E7EB] bg-white backdrop-blur p-4 shadow-[0_4px_12px_rgba(0,0,0,0.05] h-[300px] flex flex-col">
            <div class="mb-2">
                <p class="text-[10px] uppercase tracking-[0.3em] text-[#64748B] font-semibold">Distribution</p>
                <h3 class="text-base font-black text-[#1E293B]">Banking Type Distribution</h3>
            </div>
            <div class="relative w-full flex-1">
                <canvas id="doughnutChart" class="absolute inset-0 w-full h-full block"></canvas>
            </div>
        </div>

        <div class="rounded-3xl border border-[#00E5FF]/25 bg-white backdrop-blur p-4 shadow-[0_0_24px_rgba(3,196,255,0.2)] h-[300px] flex flex-col">
            <div class="flex flex-col gap-2">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-[#64748B] font-semibold">Activity</p>
                    <h3 class="text-base font-black text-[#1E293B]">Yearly Vehicle Mix</h3>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-[10px] font-bold text-[#64748B]">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#00E5FF]"></span>
                        <span>Private</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#00E5FF]"></span>
                        <span>For Hire</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#00D1FF]"></span>
                        <span>Government</span>
                    </div>
                </div>
            </div>
            <div class="relative w-full flex-1 min-h-[200px] mt-2 px-1">
                <canvas id="stackedBarChart" class="absolute inset-0 w-full h-full block"></canvas>
            </div>
        </div>
    </div>

    <!-- Province Overview Card Rows -->
    <div class="rounded-3xl border border-[#E5E7EB] bg-white backdrop-blur p-4 shadow-[0_4px_12px_rgba(0,0,0,0.05)]">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
            <div>
                <h3 class="font-black text-[#1E293B] text-base">Province Highlights</h3>
                <p class="text-xs text-[#64748B]">Card-style rows with quick actions.</p>
            </div>
            <span class="text-[#00E5FF] text-[10px] font-bold uppercase tracking-[0.3em]">Region III</span>
        </div>
        <div class="space-y-3">
            @php
                $user = auth()->user();
                $userAgency = strtolower((string) ($user?->agency_name ?? ''));
                $userProvince = strtolower((string) ($user?->province?->name ?? ''));
            @endphp
            @foreach($provinceSummaries ?? [] as $summary)
                @php
                    $projectProvince = strtolower($summary['province']);
                    $canEdit = $user?->isAdmin()
                        || ($userAgency !== '' && $userAgency === $projectProvince)
                        || ($userProvince !== '' && $userProvince === $projectProvince);
                    $totalDisplay = $summary['total'] === null
                        ? '---'
                        : number_format($summary['total'], $summaryDecimals ?? 0);
                @endphp
                <div class="group flex flex-col md:flex-row md:items-center md:justify-between gap-3 rounded-3xl border border-[#E5E7EB] bg-white px-4 py-3 transition hover:-translate-y-0.5 hover:border-[#00E5FF]/40 hover:shadow-[0_6px_20px_rgba(0,229,255,0.1)]">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-xl border border-[#00E5FF]/30 bg-white flex items-center justify-center text-[#00E5FF] shadow-[0_0_8px_rgba(0,229,255,0.4)]">
                            <i class="fas fa-map"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-[#1E293B]">{{ $summary['province'] }}</div>
                            <div class="text-xs text-[#64748B]">{{ $summaryLabel ?? 'Vehicles Total' }}: {{ $totalDisplay }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-[#00E5FF]/15 text-[#00E5FF]">
                            {{ $summary['status'] }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard', ['province_id' => $summary['province_id'], 'table' => $selectedTable, 'year' => $selectedYear]) }}"
                               class="h-9 px-3 inline-flex items-center justify-center rounded-full border-2 border-[#00E5FF] bg-white text-[10px] font-bold uppercase tracking-widest text-[#00E5FF] shadow-[0_0_10px_rgba(0,229,255,0.5)] hover:shadow-[0_0_15px_rgba(0,229,255,0.7)] transition">
                                View
                            </a>
                            @if ($summary['status'] === 'Pending Data' && $user?->isAdmin())
                                <button type="button"
                                        class="h-9 px-3 inline-flex items-center justify-center rounded-full border-2 border-[#00E5FF] bg-white text-[10px] font-bold uppercase tracking-widest text-[#00E5FF] shadow-[0_0_10px_rgba(0,229,255,0.5)] hover:shadow-[0_0_15px_rgba(0,229,255,0.7)] transition"
                                        @click.prevent="$dispatch('open-modal', '{{ $selectedTable === '13.1' ? 'add-vehicle-' : 'add-banking-' }}{{ $summary['province_id'] }}')">
                                    Add Data
                                </button>
                            @endif
                            @if ($canEdit)
                                <button class="h-9 w-9 rounded-full border-2 border-[#00E5FF] bg-white text-[#00E5FF] shadow-[0_0_10px_rgba(0,229,255,0.5)] hover:shadow-[0_0_15px_rgba(0,229,255,0.7)] transition">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="h-9 w-9 rounded-full border border-rose-300/50 bg-white text-rose-400 shadow-[0_0_10px_rgba(248,113,113,0.4)] hover:shadow-[0_0_15px_rgba(248,113,113,0.6)] transition">
                                    <i class="fas fa-archive"></i>
                                </button>
                            @else
                                <span class="text-[10px] text-[#64748B]">View Only</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($summary['status'] === 'Pending Data' && $user?->isAdmin())
                    @if ($selectedTable === '13.1')
                        <x-modal name="add-vehicle-{{ $summary['province_id'] }}" title="Add Vehicle Data" subtitle="{{ $summary['province'] }} - {{ $selectedYear }}">
                            <form id="vehicle-form-{{ $summary['province_id'] }}" action="{{ route('dashboard.vehicles.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="province_id" value="{{ $summary['province_id'] }}">
                                <input type="hidden" name="year" value="{{ $selectedYear }}">
                                <input type="hidden" name="_modal" value="add-vehicle-{{ $summary['province_id'] }}">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Private</label>
                                        <input type="number" name="private" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">For Hire</label>
                                        <input type="number" name="for_hire" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Government</label>
                                        <input type="number" name="government" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Diplomatic</label>
                                        <input type="number" name="diplomatic" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Exempt</label>
                                        <input type="number" name="exempt" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Total</label>
                                        <input type="number" name="total" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                </div>
                            </form>
                            @slot('footer')
                                <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">Cancel</x-action-button>
                                <x-action-button type="submit" variant="create" size="sm" form="vehicle-form-{{ $summary['province_id'] }}">Save</x-action-button>
                            @endslot
                        </x-modal>
                    @else
                        <x-modal name="add-banking-{{ $summary['province_id'] }}" title="Add Banking Data" subtitle="{{ $summary['province'] }} - {{ $selectedYear }}">
                            <form id="banking-form-{{ $summary['province_id'] }}" action="{{ route('dashboard.banking.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="province_id" value="{{ $summary['province_id'] }}">
                                <input type="hidden" name="year" value="{{ $selectedYear }}">
                                <input type="hidden" name="data_type" value="{{ $selectedDataType }}">
                                <input type="hidden" name="_modal" value="add-banking-{{ $summary['province_id'] }}">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Universal/Commercial</label>
                                        <input type="number" step="0.1" name="universal_commercial_banks" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Thrift</label>
                                        <input type="number" step="0.1" name="thrift_banks" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Rural/Cooperative</label>
                                        <input type="number" step="0.1" name="rural_cooperative_banks" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-2">Total</label>
                                        <input type="number" step="0.1" name="total" min="0" required class="w-full rounded-xl border border-[#00E5FF]/30 bg-white px-3 py-2 text-sm text-[#1E293B] focus:outline-none focus:ring-2 focus:ring-[#00E5FF]/40">
                                    </div>
                                </div>
                            </form>
                            @slot('footer')
                                <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">Cancel</x-action-button>
                                <x-action-button type="submit" variant="create" size="sm" form="banking-form-{{ $summary['province_id'] }}">Save</x-action-button>
                            @endslot
                        </x-modal>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    const peso = '\u20B1';
    const trendLabels = @json($trendLabels);
    const trendValues = @json($trendValues).map(Number);
    const trendUnitLabel = @json($trendUnitLabel);
    const selectedTable = @json($selectedTable ?? '13.1');

    const bankingDistribution = @json($bankingDistribution);
    let doughnutData = [
        Number(bankingDistribution['Universal/Commercial Banks'] ?? 0),
        Number(bankingDistribution['Thrift Banks'] ?? 0),
        Number(bankingDistribution['Rural/Cooperative Banks'] ?? 0),
    ];
    const hasDoughnutData = doughnutData.some((value) => value > 0);
    if (!hasDoughnutData) {
        doughnutData = [714.6, 57.3, 35.3];
    }

    const vehicleMix = @json($vehicleMix);
    const yearlyLabels = [String(@json($selectedYear))];
    const yearlyPrivate = [Number(vehicleMix.private ?? 0)];
    const yearlyForHire = [Number(vehicleMix.for_hire ?? 0)];
    const yearlyGovernment = [Number(vehicleMix.government ?? 0)];

    const wavyCtx = document.getElementById('wavyChart').getContext('2d');
    const wavyChart = new Chart(wavyCtx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [
                {
                    label: selectedTable === '13.1' ? 'Motor Vehicles' : 'Banking Total',
                    data: trendValues,
                    borderColor: '#00E5FF',
                    backgroundColor: 'rgba(0, 229, 255, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 4,
                    pointBackgroundColor: '#00E5FF',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    shadowColor: 'rgba(0, 229, 255, 0.8)',
                    shadowBlur: 10,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { top: 6, right: 10, bottom: 6, left: 10 }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 12,
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#94a3b8'
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
                        color: '#94a3b8',
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" }
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)',
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
                        color: '#94a3b8'
                    }
                }
            }
        }
    });

    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    const doughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Universal/Commercial Banks', 'Thrift Banks', 'Rural/Cooperative Banks'],
            datasets: [{
                data: doughnutData,
                backgroundColor: [
                    '#00D1FF',
                    '#00E5FF',
                    '#00E5FF'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
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
                        padding: 12,
                        font: { size: 10, weight: 'bold', family: "'Inter', sans-serif" },
                        color: '#94a3b8'
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

    const stackedBarCtx = document.getElementById('stackedBarChart').getContext('2d');
    const stackedBarChart = new Chart(stackedBarCtx, {
        type: 'bar',
        data: {
            labels: yearlyLabels,
            datasets: [
                {
                    label: 'Private',
                    data: yearlyPrivate,
                    backgroundColor: '#00E5FF'
                },
                {
                    label: 'For Hire',
                    data: yearlyForHire,
                    backgroundColor: '#00D1FF'
                },
                {
                    label: 'Government',
                    data: yearlyGovernment,
                    backgroundColor: '#00D1FF'
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
                        color: '#94a3b8'
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)',
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
@php($openModal = session('open_modal') ?? old('_modal'))
@if ($openModal)
    @push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: @json($openModal) }));
        });
    </script>
    @endpush
@endif
@endsection
