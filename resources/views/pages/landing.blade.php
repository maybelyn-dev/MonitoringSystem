<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMS Region III</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'IBM Plex Sans', sans-serif; }
        .display-font { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-900">
    <div class="min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -left-40 top-0 h-[520px] w-[520px] rounded-full bg-teal-100 blur-[80px] opacity-60"></div>
            <div class="absolute right-0 top-24 h-[520px] w-[520px] rounded-full bg-slate-100 blur-[90px] opacity-80"></div>
        </div>

        <nav class="relative z-10 max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-11 w-11 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                    <i class="fas fa-shield-halved text-lg"></i>
                </div>
                <div>
                    <div class="display-font text-lg font-bold tracking-wide">RAMS Region III</div>
                    <div class="text-[11px] uppercase tracking-[0.3em] text-slate-400">Intelligence Dashboard</div>
                </div>
            </div>
            <button id="open-login" class="hidden sm:inline-flex items-center gap-2 bg-teal-600 text-white px-5 py-2.5 rounded-full font-semibold shadow-lg shadow-teal-200 hover:bg-teal-700 transition">
                <i class="fas fa-arrow-right-to-bracket text-sm"></i>
                Enter the System
            </button>
        </nav>

        <main class="relative z-10 max-w-7xl mx-auto px-6 pb-20 pt-8 grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
            <section class="space-y-8">
                <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-1.5 text-xs uppercase tracking-[0.25em] text-slate-500">
                    Secure Government Monitoring Portal
                </div>
                <h1 class="display-font text-4xl md:text-6xl font-bold leading-tight">
                    RAMS Region III
                    <span class="block text-slate-400 text-3xl md:text-5xl">Regional Agency Monitoring System</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                    A professional intelligence dashboard built for Central Luzon. Track yearly performance, manage agency activity, and observe region-wide indicators with high-contrast clarity.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button id="open-login-cta" class="inline-flex items-center justify-center gap-2 bg-teal-600 text-white px-7 py-3 rounded-xl font-semibold shadow-xl shadow-teal-200 hover:bg-teal-700 transition">
                        Enter the System
                        <i class="fas fa-arrow-up-right-from-square text-sm"></i>
                    </button>
                    <a href="{{ route('access.request') }}" class="inline-flex items-center justify-center gap-2 border border-slate-300 text-slate-700 px-7 py-3 rounded-xl font-semibold hover:border-teal-600 hover:text-teal-700 transition">
                        Request New Access
                        <i class="fas fa-paper-plane text-sm"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4">
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="text-xs uppercase text-slate-400">Provinces</div>
                        <div class="display-font text-2xl font-bold text-slate-900">7</div>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="text-xs uppercase text-slate-400">Active Agencies</div>
                        <div class="display-font text-2xl font-bold text-slate-900">18</div>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="text-xs uppercase text-slate-400">Vehicles Tracked</div>
                        <div class="display-font text-2xl font-bold text-slate-900">1.9M</div>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="text-xs uppercase text-slate-400">Banking GDP</div>
                        <div class="display-font text-2xl font-bold text-slate-900">₱16.3B</div>
                    </div>
                </div>
            </section>

            <section class="relative">
                <div class="rounded-[2.5rem] border border-slate-200 bg-white p-6 shadow-2xl shadow-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-400">Central Luzon</div>
                            <div class="display-font text-xl font-bold">Region III Map Intelligence</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center">
                            <i class="fas fa-location-dot"></i>
                        </div>
                    </div>

                    <div class="relative rounded-3xl bg-slate-50 p-6">
                        <svg viewBox="0 0 420 360" class="w-full h-auto">
                            <defs>
                                <linearGradient id="mapFill" x1="0" x2="1" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#0f766e" stop-opacity="0.35" />
                                    <stop offset="100%" stop-color="#0d9488" stop-opacity="0.15" />
                                </linearGradient>
                            </defs>
                            <path d="M70 100 L150 40 L230 70 L310 30 L360 110 L320 200 L250 240 L220 320 L130 300 L80 220 Z" fill="url(#mapFill)" stroke="#0f766e" stroke-width="3"/>
                            <circle cx="150" cy="90" r="7" fill="#0d9488"/>
                            <circle cx="250" cy="110" r="7" fill="#0d9488"/>
                            <circle cx="290" cy="70" r="7" fill="#0d9488"/>
                            <circle cx="200" cy="200" r="7" fill="#0d9488"/>
                            <circle cx="140" cy="220" r="7" fill="#0d9488"/>
                            <circle cx="110" cy="170" r="7" fill="#0d9488"/>
                            <circle cx="260" cy="240" r="7" fill="#0d9488"/>
                            <text x="30" y="40" fill="#64748b" font-size="12" font-family="IBM Plex Sans">Aurora</text>
                            <text x="250" y="40" fill="#64748b" font-size="12" font-family="IBM Plex Sans">Bataan</text>
                            <text x="320" y="140" fill="#64748b" font-size="12" font-family="IBM Plex Sans">Pampanga</text>
                            <text x="250" y="290" fill="#64748b" font-size="12" font-family="IBM Plex Sans">Bulacan</text>
                        </svg>

                        <div class="mt-6 grid grid-cols-2 gap-4 text-xs text-slate-500">
                            <div class="rounded-2xl bg-white p-4 border border-slate-100">
                                <div class="uppercase tracking-[0.2em] text-[10px]">Yearly Focus</div>
                                <div class="mt-2 text-slate-900 font-semibold">Vehicles 13.1</div>
                            </div>
                            <div class="rounded-2xl bg-white p-4 border border-slate-100">
                                <div class="uppercase tracking-[0.2em] text-[10px]">Banking Tables</div>
                                <div class="mt-2 text-slate-900 font-semibold">16.2 / 16.3</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="relative z-10 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-sm text-slate-500">
                <div>© 2026 RAMS Region III. All rights reserved.</div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('access.request') }}" class="hover:text-teal-700 transition">Access Inquiry</a>
                    <a href="#" class="hover:text-teal-700 transition">Data Policy</a>
                </div>
            </div>
        </footer>
    </div>

    <div id="login-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60"></div>
        <div class="relative min-h-screen flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-md rounded-[2rem] bg-white p-8 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <div class="text-xs uppercase tracking-[0.3em] text-slate-400">Secure Access</div>
                        <div class="display-font text-2xl font-bold text-slate-900">Sign In</div>
                    </div>
                    <button id="close-login" class="h-10 w-10 rounded-full border border-slate-200 text-slate-500 hover:text-slate-700 hover:border-slate-300 transition">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Username</label>
                        <input type="text" name="email" required
                               class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600"
                               placeholder="agency.user@rams.gov.ph">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <input type="password" name="password" required
                               class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-600"
                               placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-teal-600 py-3 font-semibold text-white shadow-lg shadow-teal-200 hover:bg-teal-700 transition">
                        Enter Dashboard
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    Need access? 
                    <a href="{{ route('access.request') }}" class="text-teal-700 font-semibold hover:text-teal-800">Request New Access</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('login-modal');
        const openButtons = [document.getElementById('open-login'), document.getElementById('open-login-cta')];
        const closeButton = document.getElementById('close-login');

        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');

        openButtons.forEach((btn) => btn?.addEventListener('click', openModal));
        closeButton?.addEventListener('click', closeModal);
        modal?.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>
