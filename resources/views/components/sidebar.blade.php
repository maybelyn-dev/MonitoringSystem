<div class="h-full w-full bg-[#FAFAFA] text-[#1E293B] flex flex-col">
    <!-- Logo / Header -->
    <div class="p-4 lg:p-6 border-b border-[#E5E7EB] flex items-center justify-center lg:justify-start gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-[#E5E7EB] shadow-sm">
            <i class="fas fa-map-marked-alt text-[#00E5FF] shadow-[0_0_8px_rgba(0,229,255,0.6)]"></i>
        </div>
        <div class="hidden lg:block min-w-0">
            <h1 class="text-xl font-bold text-[#1E293B] truncate">RAMS Region III</h1>
            <p class="text-sm text-[#64748B] mt-1 truncate">Regional Agency Monitoring</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 py-4 overflow-y-auto">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('dashboard') ? 'text-[#1E293B] font-bold bg-white rounded-lg border border-[#00E5FF] shadow-[0_0_10px_rgba(0,229,255,0.4)]' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('dashboard') ? 'bg-[#00E5FF] shadow-[0_0_15px_rgba(0,229,255,0.6)]' : 'bg-transparent' }}"></span>
                    <span class="absolute inset-0 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-transparent border-transparent' : 'group-hover:bg-white group-hover:border group-hover:border-[#00E5FF]' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('dashboard') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('regional-statistics') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('regional-statistics') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('regional-statistics') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('regional-statistics') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3a1 1 0 011-1h0a1 1 0 011 1v18a1 1 0 01-1 1h0a1 1 0 01-1-1V3zM4 10a1 1 0 011-1h0a1 1 0 011 1v11a1 1 0 01-1 1h0a1 1 0 01-1-1V10zM18 6a1 1 0 011-1h0a1 1 0 011 1v15a1 1 0 01-1 1h0a1 1 0 01-1-1V6z"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Stats</span>
                </a>
            </li>
            <li>
                <a href="{{ route('projects.index') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('projects.*') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('projects.*') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('projects.*') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Projects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('reports') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('reports') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('reports') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Reports</span>
                </a>
            </li>
            <li>
<a href="{{ route('agencies.index') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('agencies') || request()->routeIs('agencies.*') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('agencies') || request()->routeIs('agencies.*') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('agencies') || request()->routeIs('agencies.*') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Agencies</span>
                </a>
            </li>
            @if (auth()->user()?->isAdmin())
            <li>
                <a href="{{ route('admin.users.index') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('admin.users.*') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('admin.users.*') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('admin.users.*') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857M12 8a3 3 0 100-6 3 3 0 000 6zm0 0a3 3 0 100-6 3 3 0 000 6zm0 0v2m0 4h.01"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Access</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.archive') }}" class="group relative flex items-center justify-center lg:justify-start px-3 lg:px-6 py-3 text-[#64748B] hover:text-[#1E293B] transition {{ request()->routeIs('admin.archive') ? 'text-[#1E293B] font-bold' : '' }}">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full {{ request()->routeIs('admin.archive') ? 'bg-[#00E5FF] shadow-[0_0_20px_rgba(0,229,255,0.8)]' : 'bg-transparent' }}"></span>
                    <svg class="w-5 h-5 lg:mr-3 text-[#00E5FF] {{ request()->routeIs('admin.archive') ? 'text-[#00E5FF]' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"></path>
                    </svg>
                    <span class="relative hidden lg:inline">Archive</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-white/5 hidden lg:block">
        <p class="text-xs text-[#64748B] text-center">v1.0.0 - Region III</p>
    </div>
</div>
