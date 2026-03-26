<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMS Region III - Regional Agency Monitoring System</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">RAMS REGION III</h1>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-blue-600 font-bold">Central Luzon Government</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="#" class="hover:text-blue-600 transition">Home</a>
                    <a href="#" class="hover:text-blue-600 transition">Agencies</a>
                    <a href="#" class="hover:text-blue-600 transition">Provinces</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition shadow-md shadow-blue-200">
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative flex flex-col md:flex-row min-h-[550px] overflow-hidden">
        <div class="hidden md:block w-1/4 bg-blue-700 relative">
            <div class="absolute inset-0 opacity-10 flex items-center justify-center">
                <i class="fas fa-landmark text-[15rem] text-white"></i>
            </div>
        </div>

        <div class="flex-1 bg-slate-50 p-8 md:p-20 flex flex-col justify-center relative">
            <div class="max-w-2xl">
                <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full mb-6 uppercase tracking-widest">
                    Official Monitoring Portal
                </span>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 leading-[1.1] mb-6">
                    Regional Agency <br>
                    <span class="text-blue-700 text-3xl md:text-5xl">Monitoring System</span>
                </h2>
                <p class="text-slate-600 text-lg mb-10 leading-relaxed italic border-l-4 border-blue-600 pl-6">
                    "Driving progress in Central Luzon through transparent and efficient real-time monitoring of government projects across DOST, DICT, DTI, DOH, and DepEd."
                </p>

                <div class="flex flex-col sm:flex-row gap-4 max-w-lg">
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 text-center">
                        Sign In
                    </a>
                    <div class="bg-white text-blue-600 px-8 py-3 rounded-xl font-bold border-2 border-blue-600 text-center">
                        Access via Admin
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white -mt-10 relative z-10 max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-50 text-center">
                <div class="text-3xl font-black text-blue-700">5</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Partner Agencies</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-50 text-center">
                <div class="text-3xl font-black text-blue-700">248</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Active Projects</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-50 text-center">
                <div class="text-3xl font-black text-blue-700">7</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Provinces Covered</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-50 text-center">
                <div class="text-3xl font-black text-blue-700">₱2.4B</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 mt-1">Monitored Budget</div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-sm font-bold text-blue-600 uppercase tracking-[0.3em] mb-4">Our Services</h3>
            <h2 class="text-3xl font-black text-slate-900 mb-16">Key System Features</h2>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-700 group-hover:text-white transition duration-300">
                        <i class="fas fa-project-diagram text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-3">Project Monitoring</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Real-time tracking of milestones and deliverables for government projects.</p>
                </div>

                <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition duration-300">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-file-contract text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-3">Agency Reports</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Comprehensive data generation for regional agency evaluation.</p>
                </div>

                <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 text-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-chart-pie text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-3">Data Analytics</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Visualizing project trends and budget utilization through charts.</p>
                </div>

                <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-100 transition duration-300">
                    <div class="w-16 h-16 bg-orange-100 text-orange-700 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-600 group-hover:text-white transition duration-300">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-3">Secure Access</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Role-based authentication to ensure data integrity and security.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 py-16 text-white">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marked-alt text-white"></i>
                </div>
                <div>
                    <h5 class="font-bold text-lg">RAMS Region III</h5>
                    <p class="text-slate-400 text-xs italic">Central Luzon Regional Portal</p>
                </div>
            </div>
            <div class="flex gap-6 text-slate-400 text-sm">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Use</a>
                <a href="#" class="hover:text-white">Contact Us</a>
            </div>
            <div class="text-slate-500 text-xs">
                &copy; 2026 RAMS Region III. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
