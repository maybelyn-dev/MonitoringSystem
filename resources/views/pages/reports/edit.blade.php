@extends('layouts.app')

@section('content')
<div class="space-y-3">
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-emerald-800 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-red-800 text-xs">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200/70">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-base md:text-lg font-black text-slate-900 truncate">Reports Editor</h1>
                <p class="text-[10px] md:text-xs text-slate-500 font-bold">Region: {{ $region->name }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-black text-blue-700 hover:text-blue-800 whitespace-nowrap">Back to Dashboard</a>
        </div>

        <form action="{{ route('reports.update') }}" method="POST" class="mt-3 grid grid-cols-1 lg:grid-cols-2 gap-3">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-black">Banking</p>
                    <select name="banking_year" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @foreach(range(2011, 2020) as $year)
                            <option value="{{ $year }}" {{ (int) old('banking_year', $bankingYear ?? 2020) === (int) $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label class="block text-[10px] font-black text-slate-600 mb-1">Total Liabilities (₱B)</label>
                <input
                    name="total_liabilities"
                    type="number"
                    step="0.1"
                    min="0"
                    value="{{ old('total_liabilities', $banking2020?->banking_liabilities) }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                <div class="mt-2 flex items-center justify-between">
                    <label class="block text-[10px] font-black text-slate-600">Operating Income (₱B)</label>
                    <select name="income_year" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @foreach(range(2010, 2019) as $year)
                            <option value="{{ $year }}" {{ (int) old('income_year', $incomeYear ?? 2019) === (int) $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input
                    name="operating_income"
                    type="number"
                    step="0.1"
                    min="0"
                    value="{{ old('operating_income', $income2019?->operating_income) }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-black">Vehicles</p>
                    <select name="vehicles_year" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-teal-600">
                        @foreach(range(2018, 2022) as $year)
                            <option value="{{ $year }}" {{ (int) old('vehicles_year', $vehiclesYear ?? 2022) === (int) $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 mb-1">Private Vehicles</label>
                        <input
                            name="private_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('private_vehicles', $vehicles2022?->private_vehicles) }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-600 mb-1">For Hire</label>
                        <input
                            name="for_hire"
                            type="number"
                            min="0"
                            value="{{ old('for_hire', $vehicles2022?->for_hire) }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-600 mb-1">Government (gov_t_vehicles)</label>
                        <input
                            name="gov_t_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('gov_t_vehicles', $vehicles2022?->government) }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-600 mb-1">Total Vehicles</label>
                        <input
                            name="total_vehicles"
                            type="number"
                            min="0"
                            value="{{ old('total_vehicles', $vehicles2022?->total) }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 flex items-center justify-end gap-2">
                <button type="submit" class="rounded-xl bg-blue-600 text-white px-4 py-2 text-xs font-black hover:bg-blue-700 transition">
                    Save Updates
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
