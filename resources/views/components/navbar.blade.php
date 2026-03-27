<nav class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 px-[clamp(1rem,5vw,3rem)] py-3">
        <!-- Left Side -->
        <div class="flex items-center gap-3 min-w-0">
            <button class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 text-slate-600 hover:text-teal-600 hover:border-teal-300 transition" @click="$dispatch('toggle-sidebar')">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="text-sm sm:text-base md:text-lg font-semibold text-slate-800 truncate">Regional Agency Monitoring System</h2>
        </div>

        <!-- Center -->
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('province.select') }}" method="POST" class="flex items-center gap-3">
                @csrf
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-[0.2em]">
                    Province
                </div>
                <select name="province_id" class="text-sm border border-slate-200 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-teal-600" onchange="this.form.submit()">
                    @if(Auth::user()->isSuperAdmin())
                        <option value="all" {{ empty($navSelectedProvinceId) ? 'selected' : '' }}>All Provinces</option>
                    @endif
                    @foreach($navProvinces ?? [] as $province)
                        <option value="{{ $province->id }}" {{ (string) $province->id === (string) ($navSelectedProvinceId ?? '') ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-[0.2em]">
                    Year
                </div>
                <select name="year" class="text-sm border border-slate-200 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-teal-600" onchange="this.form.submit()">
                    @foreach($navYears ?? [] as $year)
                        <option value="{{ $year }}" {{ (int) ($navSelectedYear ?? 2026) === (int) $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="hidden md:flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-full px-4 py-2">
                <i class="fas fa-search text-slate-400 text-xs"></i>
                <input type="text" placeholder="Search agencies, reports..." class="bg-transparent text-sm text-slate-600 placeholder-slate-400 focus:outline-none w-56">
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4 justify-between lg:justify-end">
            <!-- Agency Name -->
            @auth
                <div class="hidden sm:flex items-center space-x-2 text-sm text-slate-600">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-semibold">
                        {{ Auth::user()->isSuperAdmin() ? 'System Admin | Global View' : 'Agency View' }}
                    </span>
                </div>
            @endauth

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="flex items-center space-x-2 text-slate-600 hover:text-slate-800 focus:outline-none"
                >
                    <div class="w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center text-white text-sm font-bold">
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
                    class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg py-1 border border-slate-200 z-50"
                    style="display: none;"
                >
                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Logged in as</p>
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-teal-600 mt-1">{{ $navViewMode ?? 'Agency View' }}</p>
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
