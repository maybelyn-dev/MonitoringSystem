@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#050505] p-4 md:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="bg-[#111111] rounded-3xl border border-white/10 p-6 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-white">Map CSV Columns</h1>
                    <p class="text-sm text-slate-500 mt-1">Match CSV headers to Region III fields.</p>
                </div>
                <a href="{{ route('imports.region-data') }}" class="text-xs font-bold text-[#00FFA3] hover:text-[#00FFA3]">Start Over</a>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-2xl border border-rose-400/30 bg-[#120606] px-4 py-3 text-rose-200 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('imports.region-data.import') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($fields as $field => $meta)
                        <div class="rounded-3xl border border-white/10 bg-[#0F0F0F] p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-black text-slate-200">{{ $meta['label'] }}</div>
                                @if ($meta['required'])
                                    <span class="text-[10px] uppercase tracking-widest text-[#00FFA3] font-bold">Required</span>
                                @else
                                    <span class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Optional</span>
                                @endif
                            </div>
                            <select name="mapping[{{ $field }}]" class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                                <option value="">-- Ignore --</option>
                                @foreach ($headers as $header)
                                    <option value="{{ $header }}" {{ (string) ($suggestedMapping[$field] ?? '') === (string) $header ? 'selected' : '' }}>
                                        {{ $header }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-400">
                    <input type="checkbox" name="skip_invalid" value="1" checked class="rounded text-[#00FFA3]">
                    Skip invalid rows (continue importing)
                </label>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('imports.region-data') }}" class="rounded-xl border border-white/10 bg-[#0F0F0F] px-4 py-2 text-xs font-bold text-slate-400 hover:text-white">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] text-[#050505] px-4 py-2 text-xs font-black shadow-[0_0_18px_rgba(0,255,163,0.35)] hover:from-[#00FFB2] hover:to-[#36D7FF] transition">
                        Import Now
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-[#111111] rounded-3xl border border-white/10 p-6 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <h2 class="text-sm font-black text-white mb-3">Preview (first rows)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs text-slate-300">
                    <thead class="text-[10px] uppercase tracking-widest text-slate-500 border-b border-white/10">
                        <tr>
                            @foreach ($headers as $header)
                                <th class="text-left py-2 pr-4 font-semibold">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($previewRows as $row)
                            <tr class="border-b border-white/10">
                                @for ($i = 0; $i < count($headers); $i++)
                                    <td class="py-2 pr-4">{{ $row[$i] ?? '' }}</td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td class="py-3 text-slate-500">No preview rows available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
