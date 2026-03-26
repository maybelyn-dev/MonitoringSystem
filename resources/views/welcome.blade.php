<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NEO-NOIR MONITORING</title>
    @vite('resources/css/app.css')
    <style>
        :root {
            --bg: #ffffff;
            --panel: rgba(255,255,255,0.88);
            --panel-border: rgba(25,150,255,0.22);
            --text: #ffffff;
            --muted: #7f8c98;
            --neon: #03c4ff;
            --neon-dark: #0b7bbe;
            --highlight: #00d6ff;
            --shadow: 0 24px 44px rgba(20, 91, 153, 0.15);
        }

        html, body { min-height: 100%; background: var(--bg); color: var(--text); font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }
        body { margin:0; padding:0; }

        .frost {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            border-radius: 20px;
            box-shadow: var(--shadow), inset 0 0 1px rgba(255,255,255,0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .neon-border {
            box-shadow: 0 0 16px rgba(3,196,255,0.38), 0 0 26px rgba(11,123,190,0.28);
            border: 1px solid rgba(3,196,255,0.42);
        }

        .glow-blue { color: var(--neon); }
        .glow-blue-dot { width: 8px; height: 8px; border-radius: 999px; background: var(--text); box-shadow: 0 0 6px rgba(255,255,255,0.95), 0 0 12px rgba(3,196,255,0.7); }
        .text-ghost { color: var(--muted); }

        .btn-filter {
            border: 1px solid #d6dbe4;
            background: #fff;
            color: #6b7b8c;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-filter:hover { border-color: var(--neon); color: #1a2a3f; box-shadow: 0 0 16px rgba(3,196,255,0.25); }

        .sidebar .item:hover .icon,
        .sidebar .item:hover .label { color: #0c2c43; }

        .ring {
            width: 64px;
            height: 64px;
            border-radius: 999px;
            background: conic-gradient(var(--neon) 0 70%, rgba(255,255,255,0.12) 70% 100%), #121a29;
            display: grid;
            place-items: center;
            box-shadow: 0 0 20px rgba(3,196,255,0.35);
        }
        .ring span { font-size: 0.75rem; font-weight: 700; color: #fff; }

        .chart-line {
            stroke: var(--neon);
            stroke-width: 2.5;
            fill: none;
        }
        .chart-dot { fill: var(--neon); stroke: #fff; stroke-width: 2; }
    </style>
</head>
<body>
<div class="min-h-screen flex text-gray-800">
    <aside class="sidebar w-72 p-6 space-y-6" style="background:#f8f9fa; border-right:1px solid #e6ebf2;">
        <div class="mb-8">
            <div class="mb-3 text-sm font-semibold text-gray-500">System Admin | Global View</div>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-blue-300 text-blue-950 grid place-items-center font-bold">A</div>
                <div>
                    <div class="text-sm font-semibold text-gray-700">RAMS Region III</div>
                    <div class="text-xs text-gray-500">Central Luzon Monitoring</div>
                </div>
            </div>
        </div>

        <nav class="space-y-2">
            <a class="item block px-3 py-2 rounded-full bg-blue-50 border border-blue-200 text-blue-900 font-semibold shadow-sm" href="#">
                <span class="icon text-blue-600 mr-2">●</span>
                <span class="label">Dashboard</span>
            </a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">Regional Stats</a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">Projects</a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">Reports</a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">Agencies</a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">User Access</a>
            <a class="item block px-3 py-2 rounded-full text-gray-600 hover:text-blue-700" href="#">Archive Vault</a>
        </nav>
    </aside>

    <main class="flex-1 p-6 space-y-6" style="background: #fff;">
        <section class="bg-transparent">
            <p class="text-sm text-gray-500 uppercase tracking-wider mb-2">NEO-NOIR MONITORING</p>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Region III Intelligence Dashboard</h1>
            <p class="text-md text-gray-500">Live economic and administrative signals across Central Luzon.</p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
            <div class="flex items-center gap-3">
                <input class="btn-filter rounded-lg" value="All Provinces" readonly />
                <input class="btn-filter rounded-lg" value="Motor Vehicles (13.1)" readonly />
                <input class="btn-filter rounded-lg" value="2022" readonly />
            </div>
            <div class="md:col-span-2 flex justify-end gap-3">
                <button class="btn-filter">Date: 03.25.2026</button>
                <button class="btn-filter">Region III</button>
            </div>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">TOTAL REGISTERED VEHICLES</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">0 Motor Vehicles</div>
                    <div class="text-xs text-gray-500">Updated 2026-03-25</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+18.5%</span>
                    <span class="text-gray-500">72% capacity</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:72%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">TOTAL BANKING LIABILITIES</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">₱807.1B</div>
                    <div class="text-xs text-gray-500">Updated 2026-03-25</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+3.7%</span>
                    <span class="text-gray-500">64% capacity</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:64%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">STOCK MARKET CAPITALIZATION</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">1.4M</div>
                    <div class="text-xs text-gray-500">Updated 2026-03-25</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+0.6%</span>
                    <span class="text-gray-500">88% capacity</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:88%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">BUDGET UTILIZATION</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">₱16.3B</div>
                    <div class="text-xs text-gray-500">Updated 2026-03-25</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+12.1%</span>
                    <span class="text-gray-500">79% utilization</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:79%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">ECONOMIC SENTIMENT INDEX</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">714.6</div>
                    <div class="text-xs text-gray-500">Latest signal 2026-03-25</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+2.8%</span>
                    <span class="text-gray-500">57.3% score</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:57.3%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">TRAFFIC CONGESTION INDEX</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">57.3</div>
                    <div class="text-xs text-gray-500">Province average</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+6.4%</span>
                    <span class="text-gray-500">63% alert</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:63%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">DATA COMPLIANCE SCORE</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">35.3</div>
                    <div class="text-xs text-gray-500">Current rating</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+4.9%</span>
                    <span class="text-gray-500">42% plan</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:42%"></div>
                </div>
            </div>

            <div class="frost neon-border p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <h3 class="text-xs uppercase tracking-wide text-gray-500">PRIVATE VEHICLE COUNT</h3>
                    <span class="glow-blue-dot"></span>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">0 Private Vehicles</div>
                    <div class="text-xs text-gray-500">As of today</div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="glow-blue">+1.9%</span>
                    <span class="text-gray-500">46% estimated</span>
                </div>
                <div class="h-2 rounded-full overflow-hidden bg-blue-50">
                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-700" style="width:46%"></div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <article class="frost neon-border p-5 xl:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Regional Performance Trends</h2>
                    <span class="text-sm text-gray-500">Updated today</span>
                </div>
                <div class="flex items-center gap-4 mb-4">
                    <span class="inline-flex items-center gap-2 text-sm text-gray-500"><span class="w-2 h-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-700 shadow-[0_0_8px_rgba(3,196,255,0.6)]"></span>Motor Vehicles</span>
                    <span class="inline-flex items-center gap-2 text-sm text-gray-400">Data points last 30 days</span>
                </div>
                <div class="overflow-hidden rounded-xl bg-white/5 p-4">
                    <svg viewBox="0 0 800 240" class="w-full h-52">
                        <path class="chart-line" d="M40 180 C120 130 200 160 280 120 C360 100 440 140 520 90 C600 85 680 70 760 60" />
                        <circle class="chart-dot" cx="40" cy="180" r="5" />
                        <circle class="chart-dot" cx="120" cy="130" r="5" />
                        <circle class="chart-dot" cx="200" cy="160" r="5" />
                        <circle class="chart-dot" cx="280" cy="120" r="5" />
                        <circle class="chart-dot" cx="360" cy="100" r="5" />
                        <circle class="chart-dot" cx="440" cy="140" r="5" />
                        <circle class="chart-dot" cx="520" cy="90" r="5" />
                        <circle class="chart-dot" cx="600" cy="85" r="5" />
                        <circle class="chart-dot" cx="680" cy="70" r="5" />
                        <circle class="chart-dot" cx="760" cy="60" r="5" />
                    </svg>
                </div>
            </article>

            <article class="frost neon-border p-5 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">System Health</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Agency Statistics</div>
                            <div class="font-semibold text-gray-900">Online</div>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 shadow-[0_0_12px_rgba(3,196,255,0.65)]"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-gray-500 uppercase">Monitoring Sync</div>
                            <div class="font-semibold text-gray-900">Active</div>
                        </div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 shadow-[0_0_12px_rgba(3,196,255,0.65)]"></div>
                    </div>
                </div>
                <div class="pt-2 text-xs text-gray-400 border-t border-blue-100">RAMS Region III • Intelligent operations powered by ambient telemetry</div>
            </article>
        </section>
    </main>
</div>
</body>
</html>