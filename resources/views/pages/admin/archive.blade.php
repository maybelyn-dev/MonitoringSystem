@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#050505] p-4 md:p-6 lg:p-8 space-y-6">
    <div>
        <h1 class="text-3xl md:text-4xl font-black text-white">Archive Vault</h1>
        <p class="text-slate-500 mt-2">Restore archived records across the system.</p>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-400/30 bg-[#0F0F0F] px-4 py-3 text-sm font-bold text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="rounded-3xl border border-white/10 bg-[#111111] p-5 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <h2 class="text-lg font-black text-white mb-3">Archived Projects</h2>
            <div class="space-y-3">
                @forelse ($archivedProjects as $project)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-[#0F0F0F] px-4 py-3">
                        <div>
                            <div class="text-sm font-bold text-slate-200">{{ $project->name }}</div>
                            <div class="text-xs text-slate-500">Agency: {{ $project->agency?->agency_name ?? 'N/A' }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.archive.projects.restore', $project) }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] px-3 py-2 text-xs font-black text-[#050505] shadow-[0_0_18px_rgba(0,255,163,0.35)]">Restore</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">No archived projects.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#111111] p-5 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <h2 class="text-lg font-black text-white mb-3">Archived Users</h2>
            <div class="space-y-3">
                @forelse ($archivedUsers as $user)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-[#0F0F0F] px-4 py-3">
                        <div>
                            <div class="text-sm font-bold text-slate-200">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.archive.users.restore', $user) }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] px-3 py-2 text-xs font-black text-[#050505] shadow-[0_0_18px_rgba(0,255,163,0.35)]">Restore</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">No archived users.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#111111] p-5 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <h2 class="text-lg font-black text-white mb-3">Archived Banking Records</h2>
            <div class="space-y-3">
                @forelse ($archivedBanking as $banking)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-[#0F0F0F] px-4 py-3">
                        <div>
                            <div class="text-sm font-bold text-slate-200">{{ $banking->data_type }} - {{ $banking->year }}</div>
                            <div class="text-xs text-slate-500">Province: {{ $banking->province ?? $banking->province?->name ?? 'Region III' }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.archive.banking.restore', $banking) }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] px-3 py-2 text-xs font-black text-[#050505] shadow-[0_0_18px_rgba(0,255,163,0.35)]">Restore</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">No archived banking records.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-[#111111] p-5 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <h2 class="text-lg font-black text-white mb-3">Archived Vehicle Records</h2>
            <div class="space-y-3">
                @forelse ($archivedVehicles as $vehicle)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-[#0F0F0F] px-4 py-3">
                        <div>
                            <div class="text-sm font-bold text-slate-200">{{ $vehicle->year }} Vehicle Data</div>
                            <div class="text-xs text-slate-500">Province: {{ $vehicle->province ?? $vehicle->province?->name ?? 'Region III' }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.archive.vehicles.restore', $vehicle) }}">
                            @csrf
                            <button type="submit" class="rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] px-3 py-2 text-xs font-black text-[#050505] shadow-[0_0_18px_rgba(0,255,163,0.35)]">Restore</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">No archived vehicle records.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
