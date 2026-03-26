@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
        <div class="text-xs uppercase tracking-[0.3em] text-slate-400 font-semibold">403 Unauthorized</div>
        <h1 class="mt-2 text-2xl font-black text-slate-900">Access Restricted</h1>
        <p class="mt-3 text-sm text-slate-600">
            {{ $exception->getMessage() ?: '403 Unauthorized: You can only modify data within your assigned province.' }}
        </p>
        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-xs font-black text-white hover:bg-blue-700 transition">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
