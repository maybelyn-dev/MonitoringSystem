<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Regional Agency Monitoring System - Region III')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-base-url" content="{{ url('/') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.appConfig = @json([
            'baseUrl' => url('/'),
            'csrfToken' => csrf_token(),
        ]);
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Ultra-clean Light Mode with Electric Neon Blue and Cyber Cyan */
        body { background: #FFFFFF; color: #1E293B; }
        .bg-[#050505], .bg-[#0A0A0A], .bg-[#121212] { background: #FFFFFF !important; }
        .bg-[#121212]\/80 { background: #FFFFFF !important; }
        .text-slate-100, .text-slate-200, .text-slate-300, .text-slate-400 { color: #1E293B !important; }
        .text-slate-500 { color: #64748B !important; }
        .text-slate-600, .text-slate-700, .text-slate-900 { color: #1E293B !important; }
        .text-[#00FFA3], .bg-[#00FFA3], .border-[#00FFA3], .shadow-[0_0_12px_rgba(0,255,163,0.35)] { color: #00E5FF !important; background: #00E5FF !important; border-color: #00E5FF !important; box-shadow: 0 0 12px rgba(0,229,255,0.6) !important; }
        .border-white\/5, .border-white\/10, .border-[#03c4ff] { border-color: rgba(0,229,255,0.3) !important; }
        .shadow-[0_0_12px_rgba(0,255,163,0.35)] { box-shadow: 0 0 12px rgba(0,229,255,0.6) !important; }
        .shadow-[0_0_30px_rgba(0,255,163,0.15)] { box-shadow: 0 0 30px rgba(0,229,255,0.2) !important; }
        .hover\:bg-white\/5:hover { background: rgba(0,229,255,0.1) !important; }
        .bg-[#0F0F0F] { background: #FFFFFF !important; }
        input, select, .form-control, button { border-color: rgba(0,229,255,0.3) !important; }

        .hover\:bg-white\/5:hover { background: rgba(0,229,255,0.05) !important; }
        .bg-[#0F0F0F] { background: rgba(255,255,255,0.95) !important; }
        input, select, .form-control, button { border-color: rgba(0,229,255,0.2); }
    </style>
    
    @stack('styles')
</head>
<body class="bg-white antialiased text-slate-900">
    <div class="flex h-screen overflow-hidden">
        
        {{-- Sidebar Section --}}
        @if(!Request::is('/'))
            <aside class="w-20 lg:w-64 h-full m-0 shrink-0 border-r border-[#E2E8F0] bg-[#F8FAFC]">
                @include('components.sidebar')
            </aside>
        @endif

        {{-- Main Content Section --}}
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
            
            @include('components.navbar')

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto bg-[#FAFBFD]">
                <div class="w-full p-6 md:p-8">
                    <div class="max-w-[1500px] mx-auto">
                        @yield('content')
                    </div>
                </div>
            </main>

            {{-- Footer (Optional) --}}
            <footer class="bg-[#F8FAFC] border-t border-[#E2E8F0] p-3 text-center text-[10px] text-slate-500">
                &copy; {{ date('Y') }} RAMS Region III &bull; Project Monitoring System
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
