<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMS Region III | Intelligence Overview</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0f172a] text-white flex items-center justify-center">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <div>
                        <div class="text-lg font-semibold">RAMS Region III</div>
                        <div class="text-xs uppercase tracking-[0.3em] text-slate-400">Modern Intelligence</div>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-teal-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-sm shadow-teal-200 hover:bg-teal-700 transition">
                    <i class="fas fa-lock"></i>
                    Secure Login
                </a>
            </div>
        </header>

        <main class="flex-1">
            <section class="max-w-6xl mx-auto px-6 py-10">
                <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] gap-8 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 text-xs uppercase tracking-[0.2em] text-slate-500">
                            Regional Intelligence Overview
                        </div>
                        <h1 class="text-4xl md:text-5xl font-semibold leading-tight">
                            Central Luzon Performance & Monitoring
                        </h1>
                        <p class="text-slate-600 text-lg leading-relaxed">
                            Track yearly agency performance, banking indicators, and vehicle registrations across all seven provinces using a unified intelligence dashboard.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('stats.public') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-slate-800 transition">
                                <i class="fas fa-chart-line"></i>
                                Public Stats
                            </a>
                            <a href="{{ route('access.request') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-700 px-5 py-2.5 rounded-full text-sm font-semibold hover:border-teal-500 hover:text-teal-700 transition">
                                Request Access
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Yearly Summary</div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-500">Banking Liabilities</div>
                                <div class="text-lg font-semibold text-slate-900">₱807.1B</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-500">Vehicles Registered</div>
                                <div class="text-lg font-semibold text-slate-900">1.4M</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-500">Operating Income</div>
                                <div class="text-lg font-semibold text-slate-900">₱16.3B</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-500">Universal Banks</div>
                                <div class="text-lg font-semibold text-slate-900">714.6</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-200 bg-white/80 backdrop-blur-md">
            <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-slate-500 flex flex-col sm:flex-row justify-between gap-2">
                <span>© 2026 RAMS Region III</span>
                <span>Modern Intelligence Dashboard</span>
            </div>
        </footer>
    </div>
</body>
</html>
