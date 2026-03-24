<nav class="shrink-0 h-16 bg-[#0B0B0B]/80 backdrop-blur border-b border-white/5 relative z-50">
    <div class="flex items-center justify-between h-full px-[clamp(1rem,5vw,3rem)]">
        <!-- Left Side -->
        <div class="flex items-center gap-3 min-w-0">
            <h2 class="text-sm sm:text-base md:text-lg font-semibold text-slate-100 truncate">Regional Agency Monitoring System</h2>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Agency Name -->
            @auth
                <div class="flex items-center space-x-2 text-sm text-slate-300">
                    <i class="fas fa-building text-[#00FFA3]"></i>
                    <span class="font-bold">
                        @php($navUser = Auth::user())
                        @if ($navUser?->isAdmin())
                            System Admin | Global View
                        @elseif ($navUser?->isFocal())
                            Agency: {{ $navUser->agency_name ?? $navUser->agency?->agency_name ?? 'N/A' }}
                        @else
                            Agency: {{ $navUser->agency_name ?? $navUser->agency?->agency_name ?? $navUser->province?->name ?? 'Region III' }}
                        @endif
                    </span>
                </div>
            @endauth

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="flex items-center space-x-2 text-slate-300 hover:text-white focus:outline-none"
                >
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#0A0A0A] text-sm font-bold bg-[#00FFA3] shadow-[0_0_12px_rgba(0,255,163,0.35)]">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="open"
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-[#121212] rounded-xl shadow-lg py-1 border border-white/10 z-50"
                    style="display: none;"
                >
                    <div class="px-4 py-2 border-b border-white/10">
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Logged in as</p>
                        <p class="text-sm font-bold text-slate-100">{{ Auth::user()->name }}</p>
                    </div>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-white/5">
                        <i class="fas fa-cog w-4 mr-2"></i> Settings
                    </a>
                    <hr class="my-1 border-white/10">
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/5">
                            <i class="fas fa-sign-out-alt w-4 mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
