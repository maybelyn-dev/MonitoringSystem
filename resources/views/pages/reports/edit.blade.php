@extends('layouts.app')

@section('content')
<div class="space-y-3">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-400/30 bg-[#0F0F0F] px-3 py-2 text-emerald-200 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-400/30 bg-[#120606] px-3 py-2 text-rose-200 text-xs">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#111111] rounded-3xl p-4 shadow-[0_0_24px_rgba(0,0,0,0.35)] border border-white/10">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-base md:text-lg font-black text-white truncate">Reports Summary</h1>
                <p class="text-[10px] md:text-xs text-slate-400 font-bold">Region: {{ $region->name }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-black text-[#00FFA3] hover:text-[#00FFA3] whitespace-nowrap">Back to Dashboard</a>
        </div>

        <div class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-3">
            <div class="rounded-xl border border-white/10 bg-[#0F0F0F] p-3">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-black">Province Summary (2018)</p>
                    <form action="{{ route('reports') }}" method="GET">
                        <select name="province_id" onchange="this.form.submit()"
                                class="bg-[#0F0F0F] text-slate-200 text-[11px] font-semibold rounded-lg px-2.5 py-1.5 border border-white/10 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                            @forelse($provinces->unique('name') as $p)
                                <option value="{{ $p->id }}" {{ (string) $province?->id === (string) $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @empty
                                <option value="" disabled>No provinces available</option>
                            @endforelse
                        </select>
                    </form>
                </div>

                @if(($summary['Private'] ?? 0) === 0 && ($summary['For Hire'] ?? 0) === 0 && ($summary['Government'] ?? 0) === 0)
                    <div class="rounded-lg border border-white/10 bg-[#0F0F0F] px-3 py-2 text-[11px] text-[#00FFA3]">
                        No Data Available for this province yet.
                    </div>
                @else
                    <div class="grid grid-cols-3 gap-2 text-center text-[11px]">
                        <div class="rounded-2xl bg-[#0F0F0F] border border-white/10 p-2">
                            <div class="text-slate-400 font-bold">Private</div>
                            <div class="text-white font-black">{{ number_format($summary['Private'], 0) }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#0F0F0F] border border-white/10 p-2">
                            <div class="text-slate-400 font-bold">For Hire</div>
                            <div class="text-white font-black">{{ number_format($summary['For Hire'], 0) }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#0F0F0F] border border-white/10 p-2">
                            <div class="text-slate-400 font-bold">Government</div>
                            <div class="text-white font-black">{{ number_format($summary['Government'], 0) }}</div>
                        </div>
                    </div>
                @endif

                <div class="mt-3 flex items-center justify-between">
                    <span class="text-[10px] text-slate-400">Table 13.1 • 2018</span>
                </div>
            </div>

            <div class="rounded-xl border border-white/10 bg-[#0F0F0F] p-3 text-[11px] text-slate-400">
                Use the form below to update banking and vehicle totals for the region.
            </div>
        </div>

        @php($canWrite = auth()->user()?->isAdmin())
        <div class="mt-4 flex items-center justify-end">
            @if ($canWrite)
                <x-action-button type="button" variant="create" size="sm" @click.prevent="$dispatch('open-modal', 'reports-update-modal')">
                    Update Region Data
                </x-action-button>
            @else
                <span class="text-xs text-slate-500 font-bold">Read-only access</span>
            @endif
        </div>

        <x-modal name="reports-update-modal" title="Update Region Data" subtitle="Banking and vehicle totals">
            <form id="reports-update-form" action="{{ route('reports.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="reports-update-modal">
            <div class="rounded-xl border border-white/10 bg-[#0F0F0F] p-3">
                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-2">Banking (2020)</p>

                <label class="block text-[10px] font-black text-slate-300 mb-1">Total Liabilities (₱B)</label>
                <input
                    name="total_liabilities"
                    type="number"
                    step="0.1"
                    min="0"
                    value="{{ old('total_liabilities', $banking2020?->banking_liabilities) }}"
                    class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                    @disabled(!$canWrite)
                />

                <label class="block text-[10px] font-black text-slate-300 mt-2 mb-1">Operating Income (₱B, 2019)</label>
                <input
                    name="operating_income"
                    type="number"
                    step="0.1"
                    min="0"
                    value="{{ old('operating_income', $income2019?->operating_income) }}"
                    class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                    @disabled(!$canWrite)
                />
            </div>

            <div class="rounded-xl border border-white/10 bg-[#0F0F0F] p-3">
                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-black mb-2">Vehicles (2022)</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-black text-slate-300 mb-1">Private Vehicles</label>
                        <input
                            name="private_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('private_vehicles', $vehicles2022?->private ?? $vehicles2022?->private_vehicles) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                            @disabled(!$canWrite)
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-300 mb-1">For Hire</label>
                        <input
                            name="for_hire"
                            type="number"
                            min="0"
                            value="{{ old('for_hire', $vehicles2022?->for_hire) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                            @disabled(!$canWrite)
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-300 mb-1">Government (gov_t_vehicles)</label>
                        <input
                            name="gov_t_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('gov_t_vehicles', $vehicles2022?->government) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                            @disabled(!$canWrite)
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-300 mb-1">Total Vehicles</label>
                        <input
                            name="total_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('total_vehicles', $vehicles2022?->total) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40"
                            @disabled(!$canWrite)
                        />
                    </div>
                </div>
            </div>

            </form>
            @slot('footer')
                <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">Cancel</x-action-button>
                @if ($canWrite)
                    <x-action-button type="submit" variant="create" size="sm" form="reports-update-form">Save Updates</x-action-button>
                @endif
            @endslot
        </x-modal>
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
