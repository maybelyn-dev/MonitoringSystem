<nav class="shrink-0 bg-white/90 backdrop-blur border-b border-slate-200 relative z-50">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-[clamp(1rem,5vw,3rem)] py-4">
        <div>
            <div class="text-xs uppercase tracking-[0.3em] text-slate-400">Public Viewing</div>
            <h2 class="text-lg font-semibold text-slate-800">RAMS Region III Statistics</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('landing') }}" class="text-sm text-slate-600 hover:text-teal-700 transition">Back to Home</a>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-teal-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg shadow-teal-200 hover:bg-teal-700 transition">
                <i class="fas fa-lock"></i>
                Secure Login
            </a>
        </div>
    </div>
</nav>
