<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Regional Agency Monitoring System - Region III')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-50 antialiased text-slate-900">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
        
        {{-- Sidebar Section --}}
        @if(Auth::check() && !Request::is('/'))
            <aside class="fixed inset-y-0 left-0 z-50 w-64 transform lg:translate-x-0 transition duration-300 bg-[#0f172a] border-r border-slate-800"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                @include('components.sidebar')
            </aside>
            <div class="lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false">
                <div class="fixed inset-0 bg-slate-900/60 z-40"></div>
            </div>
        @endif

        {{-- Main Content Section --}}
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden lg:ml-64">
            
            @if(Auth::check())
                @include('components.navbar')
            @elseif(Request::is('stats'))
                @include('components.public-navbar')
            @endif

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto bg-slate-50">
                <div class="w-full p-8">
                    <div class="max-w-[1400px] mx-auto">
                        @yield('content')
                    </div>
                </div>
            </main>

            {{-- Footer (Optional) --}}
            <footer class="bg-white border-t border-slate-200/40 p-3 text-center text-[10px] text-slate-400">
                &copy; {{ date('Y') }} RAMS Region III &bull; Project Monitoring System
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
