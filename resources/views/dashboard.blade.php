<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regional Monitoring System Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/dashboard.js'])
</head>
<body class="bg-charcoal-950 text-white font-sans overflow-x-hidden">
    <!-- Animated background grid -->
    <div class="fixed inset-0 opacity-5 pointer-events-none" style="background-image: linear-gradient(0deg, transparent 24%, rgba(0, 255, 221, .05) 25%, rgba(0, 255, 221, .05) 26%, transparent 27%, transparent 74%, rgba(0, 255, 221, .05) 75%, rgba(0, 255, 221, .05) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(0, 255, 221, .05) 25%, rgba(0, 255, 221, .05) 26%, transparent 27%, transparent 74%, rgba(0, 255, 221, .05) 75%, rgba(0, 255, 221, .05) 76%, transparent 77%, transparent); background-size: 50px 50px;"></div>

    <!-- Container -->
    <div class="relative z-10">
        <!-- Header -->
        <header class="sticky top-0 z-50 backdrop-blur-md bg-charcoal-950/50 border-b border-neon-blue/20 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-neon-blue to-cyan-500 p-0.5 shadow-lg shadow-neon-blue/50">
                        <div class="w-full h-full bg-charcoal-950 rounded-md flex items-center justify-center font-bold text-neon-blue text-lg">R3</div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">Monitoring System</h1>
                        <p class="text-xs text-gray-400">Central Luzon Regional Data Hub</p>
                    </div>
                </div>
                
                <nav class="flex items-center gap-6">
                    <div class="hidden md:flex gap-6">
                        <a href="#analytics" class="text-sm text-gray-300 hover:text-neon-blue transition-colors">Analytics</a>
                        <a href="#data" class="text-sm text-gray-300 hover:text-neon-blue transition-colors">Data</a>
                        <a href="#reports" class="text-sm text-gray-300 hover:text-neon-blue transition-colors">Reports</a>
                    </div>
                    <button class="px-4 py-2 rounded-lg bg-gradient-to-r from-neon-blue to-cyan-500 text-charcoal-950 font-semibold hover:shadow-lg hover:shadow-neon-blue/50 transition-all hover:-translate-y-0.5">
                        Export
                    </button>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-6 py-12">
            <!-- KPI Cards Section -->
            <section id="analytics" class="mb-12 scroll-mt-24">
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
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                                    </svg>
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
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
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
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
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
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
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
            <section id="data" class="mb-12 scroll-mt-24">
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
                            <canvas id="lineChart" class="w-full h-64"></canvas>
                            <div class="mt-4 flex justify-between text-xs text-gray-400">
                                <span>Q1 2026</span>
                                <span>Q4 2026</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bar Chart Card -->
                    <div class="glass-card glass-card-lg hover-glow">
                        <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative">
                            <h3 class="text-lg font-semibold mb-6 text-gray-100">Regional Distribution</h3>
                            <canvas id="barChart" class="w-full h-64"></canvas>
                            <div class="mt-4 flex justify-between text-xs text-gray-400">
                                <span>Pampanga</span>
                                <span>Laguna</span>
                                <span>Bulacan</span>
                                <span>Others</span>
                            </div>
                        </div>
                    </div>

                    <!-- Donut Chart Card -->
                    <div class="glass-card hover-glow">
                        <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative">
                            <h3 class="text-lg font-semibold mb-6 text-gray-100">Project Status</h3>
                            <canvas id="donutChart" class="w-full h-48"></canvas>
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

            <!-- Recent Data Section -->
            <section id="reports" class="mb-12 scroll-mt-24">
                <h2 class="text-xl font-bold mb-6 text-gray-100 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-neon-blue to-cyan-500 rounded-full"></span>
                    Recent Activity
                </h2>

                <div class="glass-card glass-card-lg hover-glow">
                    <div class="absolute inset-0 bg-gradient-to-br from-neon-blue/5 to-transparent rounded-2xl opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full">
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
                                <tr class="hover:bg-neon-blue/5 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-300">Region III</td>
                                    <td class="px-6 py-4 text-sm text-gray-300">Nueva Ecija</td>
                                    <td class="px-6 py-4 text-sm text-white font-medium">Resource Allocation</td>
                                    <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30">Completed</span></td>
                                    <td class="px-6 py-4"><div class="h-1.5 bg-charcoal-800 rounded-full overflow-hidden w-24"><div class="h-full w-full bg-gradient-to-r from-neon-blue to-cyan-500"></div></div></td>
                                    <td class="px-6 py-4 text-sm text-gray-400">1d ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t border-neon-blue/20 bg-charcoal-950/50 backdrop-blur-md mt-12">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 mb-4">Platform</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Dashboard</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Analytics</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Reports</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 mb-4">Resources</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">API Reference</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 mb-4">Company</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-neon-blue transition-colors">About</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 mb-4">Legal</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Privacy</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">Terms</a></li>
                            <li><a href="#" class="hover:text-neon-blue transition-colors">License</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-neon-blue/10 pt-8 flex flex-col md:flex-row items-center justify-between text-sm text-gray-400">
                    <p>&copy; 2026 Central Luzon Regional Monitoring System. All rights reserved.</p>
                    <div class="flex gap-4 mt-4 md:mt-0">
                        <a href="#" class="hover:text-neon-blue transition-colors">Twitter</a>
                        <a href="#" class="hover:text-neon-blue transition-colors">GitHub</a>
                        <a href="#" class="hover:text-neon-blue transition-colors">LinkedIn</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Chart.js for data visualization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</body>
</html>
