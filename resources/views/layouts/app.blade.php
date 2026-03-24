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
    </style>
    
    @stack('styles')
</head>
<body class="bg-[#050505] antialiased text-slate-100">
    <div class="flex h-screen overflow-hidden">
        
        {{-- Sidebar Section --}}
        @if(!Request::is('/'))
            <aside class="w-20 lg:w-64 h-full m-0 shrink-0 border-r border-white/5 bg-[#050505]">
                @include('components.sidebar')
            </aside>
        @endif

        {{-- Main Content Section --}}
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
            
            @include('components.navbar')

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto bg-[#050505]">
                <div class="w-full p-6 md:p-8">
                    <div class="max-w-[1500px] mx-auto">
                        @yield('content')
                    </div>
                </div>
            </main>

            {{-- Footer (Optional) --}}
            <footer class="bg-[#050505] border-t border-white/5 p-3 text-center text-[10px] text-slate-500">
                &copy; {{ date('Y') }} RAMS Region III &bull; Project Monitoring System
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
