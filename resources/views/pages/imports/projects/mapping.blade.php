@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Map CSV Columns</h1>
                    <p class="text-sm text-slate-500 mt-1">Match CSV columns to project fields before importing.</p>
                </div>
                <a href="{{ route('imports.projects') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800">Start Over</a>
            </div>

            @if ($errors->any())
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('imports.projects.import') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($fields as $field => $meta)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-black text-slate-800">{{ $meta['label'] }}</div>
                                @if ($meta['required'])
                                    <span class="text-[10px] uppercase tracking-widest text-rose-600 font-bold">Required</span>
                                @else
                                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Optional</span>
                                @endif
                            </div>
                            <select name="mapping[{{ $field }}]" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Ignore --</option>
                                @foreach ($headers as $header)
                                    <option value="{{ $header }}">{{ $header }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="skip_duplicates" value="1" class="rounded text-blue-600">
                    Skip duplicate rows (name + agency_id)
                </label>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('imports.projects') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-xl bg-blue-600 text-white px-4 py-2 text-xs font-black hover:bg-blue-700 transition">
                        Import Now
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-black text-slate-800">Preview (first rows)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs text-slate-700">
                    <thead class="text-[10px] uppercase tracking-widest text-slate-400 border-b border-slate-100">
                        <tr>
                            @foreach ($headers as $header)
                                <th class="text-left py-2 pr-4 font-semibold">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($previewRows as $row)
                            <tr class="border-b border-slate-50">
                                @for ($i = 0; $i < count($headers); $i++)
                                    <td class="py-2 pr-4">{{ $row[$i] ?? '' }}</td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td class="py-3 text-slate-400">No preview rows available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
