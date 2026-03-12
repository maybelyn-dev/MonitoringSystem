<nav class="shrink-0 h-16 bg-white/90 backdrop-blur border-b border-slate-200 relative z-50">
    <div class="flex items-center justify-between h-full px-[clamp(1rem,5vw,3rem)]">
        <!-- Left Side -->
        <div class="flex items-center gap-3 min-w-0">
            <h2 class="text-sm sm:text-base md:text-lg font-semibold text-slate-800 truncate">Regional Agency Monitoring System</h2>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Agency Name -->
            @auth
                <div class="flex items-center space-x-2 text-sm text-slate-600">
                    <i class="fas fa-building text-blue-600"></i>
                    <span class="font-bold">
                        {{ Auth::user()->province?->name ?? Auth::user()->agency?->agency_name ?? 'Region III' }}
                    </span>
                </div>
            @endauth

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="flex items-center space-x-2 text-slate-600 hover:text-slate-800 focus:outline-none"
                >
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
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
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 border border-slate-200 z-50"
                    style="display: none;"
                >
                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Logged in as</p>
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                    </div>
                    <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-cog w-4 mr-2"></i> Settings
                    </a>
                    <hr class="my-1">
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-4 mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
