@extends('layouts.app')

@section('title', 'Dashboard - Regional Monitoring System')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">Dashboard</h1>
            <p class="text-gray-400">Central Luzon Regional Data Hub</p>
        </div>
        <button class="px-6 py-3 rounded-lg bg-gradient-to-r from-neon-blue to-cyan-500 text-charcoal-950 font-semibold hover:shadow-lg hover:shadow-neon-blue/50 transition-all hover:-translate-y-0.5">
            <i class="fas fa-download mr-2"></i>Export Report
        </button>
    </div>

    <!-- KPI Cards Section -->
    <section id="analytics">
        <h2 class="text-xl font-bold mb-6 text-gray-100 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-neon-blue to-cyan-500 rounded-full"></span>
            Key Performance Indicators
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- KPI Card 1 -->
            <div class="glass-card group hover-glow cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-300">Provinces</h3>
                        <div class="w-10 h-10 rounded-lg bg-neon-blue/10 flex items-center justify-center text-neon-blue">
                            <i class="fas fa-map"></i>
                        </div>
                    </div>
                    <div class="mb-2">
                        <p class="text-3xl font-bold text-white">12</p>
                        <p class="text-xs text-neon-blue mt-1">+2 this month</p>
                    </div>
                    <div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
                        <div class="h-full w-3/4 bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- KPI Card 2 -->
            <div class="glass-card group hover-glow cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-300">Active Projects</h3>
                        <div class="w-10 h-10 rounded-lg bg-neon-blue/10 flex items-center justify-center text-neon-blue">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                    <div class="mb-2">
                        <p class="text-3xl font-bold text-white">248</p>
                        <p class="text-xs text-neon-blue mt-1">+18% growth</p>
                    </div>
                    <div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
                        <div class="h-full w-4/5 bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- KPI Card 3 -->
            <div class="glass-card group hover-glow cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-300">Data Sources</h3>
                        <div class="w-10 h-10 rounded-lg bg-neon-blue/10 flex items-center justify-center text-neon-blue">
                            <i class="fas fa-database"></i>
                        </div>
                    </div>
                    <div class="mb-2">
                        <p class="text-3xl font-bold text-white">1,542</p>
                        <p class="text-xs text-neon-blue mt-1">Real-time sync</p>
                    </div>
                    <div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
                        <div class="h-full w-5/6 bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- KPI Card 4 -->
            <div class="glass-card group hover-glow cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-300">System Health</h3>
                        <div class="w-10 h-10 rounded-lg bg-neon-blue/10 flex items-center justify-center text-neon-blue">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                    <div class="mb-2">
                        <p class="text-3xl font-bold text-white">99.8%</p>
                        <p class="text-xs text-neon-blue mt-1">Uptime</p>
                    </div>
                    <div class="h-1 bg-charcoal-800 rounded-full overflow-hidden">
                        <div class="h-full w-full bg-gradient-to-r from-neon-blue to-cyan-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section id="data">
        <h2 class="text-xl font-bold mb-6 text-gray-100 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-neon-blue to-cyan-500 rounded-full"></span>
            Regional Analytics
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Line Chart Card -->
            <div class="glass-card glass-card-lg hover-glow">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold mb-6 text-gray-100">Economic Growth Trend</h3>
                    <canvas id="lineChart" class="w-full" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Bar Chart Card -->
            <div class="glass-card glass-card-lg hover-glow">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold mb-6 text-gray-100">Regional Distribution</h3>
                    <canvas id="barChart" class="w-full" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Donut Chart Card -->
            <div class="glass-card hover-glow">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold mb-6 text-gray-100">Project Status</h3>
                    <canvas id="donutChart" class="w-full" style="max-height: 250px;"></canvas>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="glass-card hover-glow">
                <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h3 class="text-lg font-semibold mb-6 text-gray-100">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neon-blue/5 border border-neon-blue/20 hover:border-neon-blue/50 transition-colors">
                            <span class="text-sm text-gray-300">Total Revenue</span>
                            <span class="text-lg font-bold text-neon-blue">₱2.4B</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neon-blue/5 border border-neon-blue/20 hover:border-neon-blue/50 transition-colors">
                            <span class="text-sm text-gray-300">Avg Growth Rate</span>
                            <span class="text-lg font-bold text-cyan-400">+12.5%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neon-blue/5 border border-neon-blue/20 hover:border-neon-blue/50 transition-colors">
                            <span class="text-sm text-gray-300">Active Agencies</span>
                            <span class="text-lg font-bold text-neon-blue">45</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-neon-blue/5 border border-neon-blue/20 hover:border-neon-blue/50 transition-colors">
                            <span class="text-sm text-gray-300">Completion Rate</span>
                            <span class="text-lg font-bold text-cyan-400">87%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activity Section -->
    <section id="reports">
        <h2 class="text-xl font-bold mb-6 text-gray-100 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-neon-blue to-cyan-500 rounded-full"></span>
            Recent Activity
        </h2>

        <div class="glass-card glass-card-lg hover-glow overflow-x-auto">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
            <table class="w-full relative">
                <thead>
                    <tr class="border-b border-neon-blue/20">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Region</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Province</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Project</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Progress</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-charcoal-800 hover:bg-neon-blue/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-300">Region III</td>
                        <td class="px-6 py-4 text-sm text-gray-300">Pampanga</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">Economic Stimulus</td>
                        <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Active</span></td>
                        <td class="px-6 py-4"><div class="h-1.5 bg-charcoal-800 rounded-full overflow-hidden w-24"><div class="h-full w-4/5 bg-gradient-to-r from-neon-blue to-cyan-500"></div></div></td>
                        <td class="px-6 py-4 text-sm text-gray-400">2h ago</td>
                    </tr>
                    <tr class="border-b border-charcoal-800 hover:bg-neon-blue/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-300">Region III</td>
                        <td class="px-6 py-4 text-sm text-gray-300">Laguna</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">Infrastructure Dev</td>
                        <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">In Progress</span></td>
                        <td class="px-6 py-4"><div class="h-1.5 bg-charcoal-800 rounded-full overflow-hidden w-24"><div class="h-full w-3/5 bg-gradient-to-r from-neon-blue to-cyan-500"></div></div></td>
                        <td class="px-6 py-4 text-sm text-gray-400">4h ago</td>
                    </tr>
                    <tr class="border-b border-charcoal-800 hover:bg-neon-blue/5 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-300">Region III</td>
                        <td class="px-6 py-4 text-sm text-gray-300">Bulacan</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">Data Architecture</td>
                        <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Pending</span></td>
                        <td class="px-6 py-4"><div class="h-1.5 bg-charcoal-800 rounded-full overflow-hidden w-24"><div class="h-full w-1/5 bg-gradient-to-r from-neon-blue to-cyan-500"></div></div></td>
                        <td class="px-6 py-4 text-sm text-gray-400">8h ago</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all charts
        initializeCharts();
        setupAnimations();
    });

    function initializeCharts() {
        Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = 'rgba(0, 255, 221, 0.1)';

        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const gradient = lineCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 255, 221, 0.3)');
        gradient.addColorStop(1, 'rgba(0, 255, 221, 0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Growth (%)',
                    data: [12, 19, 3, 5, 2, 3, 14, 18, 16, 15, 17, 21],
                    borderColor: '#00ffdd',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#00ffdd',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true, labels: { usePointStyle: true, padding: 20 } }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 255, 221, 0.05)' },
                        ticks: { color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                }
            }
        });

        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Pampanga', 'Laguna', 'Bulacan', 'Nueva Ecija', 'Batangas'],
                datasets: [{
                    label: 'Q3 2026',
                    data: [320, 280, 250, 220, 190],
                    backgroundColor: 'rgba(0, 255, 221, 0.8)',
                    borderColor: '#00ffdd',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: true, labels: { usePointStyle: true } } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 255, 221, 0.05)' },
                        ticks: { color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                }
            }
        });

        // Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Pending'],
                datasets: [{
                    data: [87, 98, 45],
                    backgroundColor: ['#10b981', '#00ffdd', '#f59e0b'],
                    borderColor: '#0a0e27',
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: { legend: { display: true, position: 'bottom', labels: { usePointStyle: true } } }
            }
        });
    }

    function setupAnimations() {
        // Add fade-in animation to cards
        document.querySelectorAll('.glass-card').forEach(card => {
            card.classList.add('animate-fade-in');
        });
    }
</script>
@endpush

@endsection
