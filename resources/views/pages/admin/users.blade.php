@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#050505] p-4 md:p-6 lg:p-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-black text-white">User Access</h1>
        <p class="text-slate-500 mt-2">Assign roles and agencies for predefined users.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-[#0F0F0F] border border-emerald-400/30 rounded-2xl">
            <p class="text-sm font-bold text-emerald-200">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-4">
        @foreach ($users as $user)
            <div class="rounded-3xl border border-white/10 bg-[#111111] p-5 shadow-[0_0_24px_rgba(0,0,0,0.35)]" x-data="{ role: '{{ $user->role ?? 'focal' }}' }">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <div class="text-base font-black text-white">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                    </div>

                    
                    <div class="flex flex-col md:flex-row md:items-center gap-3 text-xs text-slate-400">
                        <div>
                            <span class="uppercase tracking-widest text-slate-500">Role</span>
                            <div class="text-slate-200 font-semibold">{{ $user->role ?? 'focal' }}</div>
                        </div>
                        <div>
                            <span class="uppercase tracking-widest text-slate-500">Agency</span>
                            <div class="text-slate-200 font-semibold">{{ $user->agency_name ?? '?' }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] text-[#050505] font-bold shadow-[0_0_18px_rgba(0,255,163,0.35)] hover:from-[#00FFB2] hover:to-[#36D7FF] transition" @click="$dispatch('open-modal', 'user-edit-{{ $user->id }}')">
                                Edit User
                            </button>
                            <button type="button" class="px-4 py-2 rounded-xl border border-rose-400/40 text-rose-300 font-bold hover:bg-rose-500/10 transition" @click="$dispatch('open-modal', 'user-archive-{{ $user->id }}')">
                                Archive
                            </button>
                        </div>
                    </div>

                </div>

                @if ($errors->has('agency_name') && session('errors')->getBag('default')->any())
                    <p class="text-xs text-rose-300 mt-2">{{ $errors->first('agency_name') }}</p>
                @endif
            </div>
        
            <x-modal name="user-edit-{{ $user->id }}" title="Edit User Access" subtitle="{{ $user->name }}">
                <form id="user-edit-form-{{ $user->id }}" action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_modal" value="user-edit-{{ $user->id }}">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2">Role</label>
                        <select name="role" x-model="role" class="w-full px-3 py-2 rounded-xl bg-[#0F0F0F] border border-white/10 text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                            <option value="admin">Admin</option>
                            <option value="focal">Focal</option>
                            <option value="focal_viewer">Focal Viewer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-2">Agency (Focal Only)</label>
                        <select name="agency_name" :disabled="role !== 'focal'" class="w-full px-3 py-2 rounded-xl bg-[#0F0F0F] border border-white/10 text-slate-200 font-medium disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                            <option value="" {{ empty($user->agency_name) ? 'selected' : '' }}>--</option>
                            <option value="DICT" {{ $user->agency_name === 'DICT' ? 'selected' : '' }}>DICT</option>
                            <option value="PSA" {{ $user->agency_name === 'PSA' ? 'selected' : '' }}>PSA</option>
                        </select>
                        @if ($errors->has('agency_name') && session('errors')->getBag('default')->any())
                            <p class="text-xs text-rose-300 mt-2">{{ $errors->first('agency_name') }}</p>
                        @endif
                    </div>
                </form>
                @slot('footer')
                    <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">Cancel</x-action-button>
                    <x-action-button type="submit" variant="create" size="sm" form="user-edit-form-{{ $user->id }}">Save Changes</x-action-button>
                @endslot
            </x-modal>

            <x-modal name="user-archive-{{ $user->id }}" title="Archive User" subtitle="{{ $user->name }}">
                <p class="text-sm text-slate-400">Archiving will hide this user from active lists. You can restore them from the Archive Vault.</p>
                <form id="user-archive-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="_modal" value="user-archive-{{ $user->id }}">
                </form>
                @slot('footer')
                    <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">Cancel</x-action-button>
                    <x-action-button type="submit" variant="archive" size="sm" form="user-archive-form-{{ $user->id }}">Archive User</x-action-button>
                @endslot
            </x-modal>

        @endforeach
    </div>
</div>
@php($openModal = session('open_modal') ?? old('_modal'))
@if ($openModal)
    @push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: @json($openModal) }));
        });
    </script>
    @endpush
@endif

@endsection
