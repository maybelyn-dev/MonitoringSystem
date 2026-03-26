@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <div class="mb-8">
        <x-action-button href="{{ route('projects.index') }}" variant="view" size="sm" icon="fas fa-arrow-left" class="mb-4">
            Back to Projects
        </x-action-button>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900">Project Details</h1>
        <p class="text-slate-500 mt-2">{{ $project->name }}</p>
    </div>

    <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-sm border border-blue-100">
        <div class="space-y-5 text-sm text-slate-600">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-[11px] uppercase tracking-widest text-slate-400">Budget</p>
                    <p class="mt-2 text-base font-bold text-slate-800">{!! 'â‚±' !!}{{ number_format($project->budget, 2) }}</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-[11px] uppercase tracking-widest text-slate-400">Status</p>
                    <p class="mt-2 text-base font-bold text-slate-800">{{ $project->status }}</p>
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                <p class="text-[11px] uppercase tracking-widest text-slate-400">Description</p>
                <p class="mt-2 text-slate-700">{{ $project->description ?: 'No description provided.' }}</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-[11px] uppercase tracking-widest text-slate-400">Start</p>
                    <p class="mt-2 font-semibold text-slate-700">{{ $project->start_date?->format('M d, Y') ?? '—' }}</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-[11px] uppercase tracking-widest text-slate-400">End</p>
                    <p class="mt-2 font-semibold text-slate-700">{{ $project->end_date?->format('M d, Y') ?? '—' }}</p>
                </div>
                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                    <p class="text-[11px] uppercase tracking-widest text-slate-400">Progress</p>
                    <div class="mt-3 flex items-center gap-3">
                        <div class="h-2 flex-1 rounded-full bg-slate-200">
                            <div class="h-2 rounded-full bg-blue-600" style="width: {{ $project->progress }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-600">{{ $project->progress }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
