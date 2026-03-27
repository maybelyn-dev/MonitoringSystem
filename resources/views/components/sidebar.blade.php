<div class="h-full w-full bg-[#0f172a] text-white flex flex-col">
    <!-- Logo / Header -->
    <div class="p-5 border-b border-slate-800 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-teal-300">
            <i class="fas fa-satellite-dish"></i>
        </div>
        <div class="min-w-0">
            <h1 class="text-lg font-semibold text-white truncate">RAMS Region III</h1>
            <p class="text-xs text-slate-400 mt-1 truncate">Intelligence Dashboard</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 py-4 overflow-y-auto">
        <ul class="space-y-1">
            @php
                $navItem = function ($isActive) {
                    return $isActive
                        ? 'bg-slate-800/70 text-teal-400'
                        : 'text-slate-400 hover:bg-slate-800/50 hover:text-white';
                };
            @endphp
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem(request()->routeIs('dashboard')) }}">
                    <i class="fas fa-gauge-high text-sm"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('regional-statistics') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem(request()->routeIs('regional-statistics')) }}">
                    <i class="fas fa-chart-line text-sm"></i>
                    <span>Regional Stats</span>
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem(request()->routeIs('projects.*')) }}">
                    <i class="fas fa-diagram-project text-sm"></i>
                    <span>Projects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem(request()->routeIs('reports')) }}">
                    <i class="fas fa-file-waveform text-sm"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('agencies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem(request()->routeIs('agencies') || request()->routeIs('agencies.*')) }}">
                    <i class="fas fa-building-columns text-sm"></i>
                    <span>Agencies</span>
                </a>
            </li>
            <li>
                <a href="{{ route('access.request') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-slate-400 hover:bg-slate-800/50 hover:text-white">
                    <i class="fas fa-shield-check text-sm"></i>
                    <span>Access</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition text-slate-400 hover:bg-slate-800/50 hover:text-white">
                    <i class="fas fa-archive text-sm"></i>
                    <span>Archive</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-slate-800">
        <p class="text-xs text-slate-500">v1.0 • Central Luzon</p>
    </div>
</div>
