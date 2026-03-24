@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl border border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Import Projects (CSV)</h1>
                    <p class="text-sm text-slate-500 mt-1">Upload a CSV file, map columns, then confirm.</p>
                </div>
                <a href="{{ route('projects.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800">Back to Projects</a>
            </div>

            @if (session('success'))
                <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('import_errors'))
                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900 text-sm">
                    <div class="font-bold">Some rows were skipped:</div>
                    <ul class="list-disc pl-5 space-y-1 mt-2">
                        @foreach (session('import_errors') as $rowError)
                            <li>
                                Row {{ $rowError['row'] }}: {{ implode('; ', $rowError['messages']) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('imports.projects.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">CSV File</label>
                    <input type="file" name="csv_file" accept=".csv,text/csv" required
                           class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="has_header" value="1" checked class="rounded text-blue-600">
                    File includes a header row
                </label>

                <button type="submit" class="w-full rounded-xl bg-blue-600 text-white px-4 py-3 text-sm font-black hover:bg-blue-700 transition">
                    Upload & Continue
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
