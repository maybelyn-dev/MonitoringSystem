@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#050505] p-4 md:p-6 lg:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-[#111111] rounded-3xl border border-white/10 p-6 shadow-[0_0_24px_rgba(0,0,0,0.35)]">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-white">Region III Data Import</h1>
                    <p class="text-sm text-slate-500 mt-1">Upload official CSV files for motor vehicles or banking data.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="text-xs font-bold text-[#00FFA3] hover:text-[#00FFA3]">Back to Dashboard</a>
            </div>

            @if (session('success'))
                <div class="mt-4 rounded-2xl border border-emerald-400/30 bg-[#0F0F0F] px-4 py-3 text-emerald-200 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-2xl border border-rose-400/30 bg-[#120606] px-4 py-3 text-rose-200 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('warnings'))
                <div class="mt-4 rounded-2xl border border-white/10 bg-[#0F0F0F] px-4 py-3 text-slate-300 text-sm">
                    <div class="font-bold text-[#00FFA3]">Warnings</div>
                    <ul class="list-disc pl-5 space-y-1 mt-2">
                        @foreach (session('warnings') as $warning)
                            <li>{{ $warning }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('imports.region-data.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">Dataset Type</label>
                    <select name="data_type" class="w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-4 py-3 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                        <option value="motor_vehicles">Motor Vehicles (Table 13.1)</option>
                        <option value="banking_liabilities">Banking Liabilities (Table 16.2)</option>
                        <option value="operating_income">Operating Income (Table 16.3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2">CSV File</label>
                    <input type="file" name="csv_file" accept=".csv,text/csv" required
                           class="block w-full rounded-xl border border-white/10 bg-[#0F0F0F] px-4 py-3 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00FFA3]/40">
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-400">
                    <input type="checkbox" name="has_header" value="1" checked class="rounded text-[#00FFA3]">
                    File includes a header row
                </label>

                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-[#00FFA3] to-[#00D1FF] text-[#050505] px-4 py-3 text-sm font-black shadow-[0_0_18px_rgba(0,255,163,0.35)] hover:from-[#00FFB2] hover:to-[#36D7FF] transition">
                    Upload & Continue
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
