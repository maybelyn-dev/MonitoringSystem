@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900">Projects</h1>
                <p class="text-slate-500 mt-2">Manage your agency's projects</p>
            </div>
            @if (auth()->user()?->canWrite())
                <x-action-button
                    href="{{ route('projects.create') }}"
                    variant="create"
                    size="md"
                    icon="fas fa-plus"
                    @click.prevent="$dispatch('open-modal', 'project-create')"
                >
                    Create
                </x-action-button>
            @endif
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
            <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Projects Table -->
    <div class="bg-white rounded-[2rem] p-4 md:p-6 lg:p-8 shadow-sm border border-blue-100">
        @if ($projects->count() > 0)
            <div class="overflow-x-auto -mx-4 md:mx-0">
                <table class="w-full text-left text-xs md:text-sm">
                    <thead>
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-100">
                            <th class="pb-4 px-4 font-bold">Project Name</th>
                            <th class="pb-4 px-4 font-bold">Budget</th>
                            <th class="pb-4 px-4 font-bold">Progress</th>
                            <th class="pb-4 px-4 font-bold">Status</th>
                            <th class="pb-4 px-4 font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @foreach ($projects as $project)
                            <tr class="border-b border-slate-50 hover:bg-blue-50/30 transition">
                                <td class="py-4 px-4 font-bold text-slate-800">{{ $project->name }}</td>
                                <td class="py-4 px-4">{!! 'â‚±' !!}{{ number_format($project->budget, 2) }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-2 bg-slate-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $project->progress }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-600">{{ $project->progress }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full text-[9px] md:text-[10px] font-black uppercase inline-block whitespace-nowrap">
                                        {{ $project->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex flex-wrap gap-2">
                                        <x-action-button
                                            href="{{ route('projects.show', $project) }}"
                                            variant="view"
                                            size="xs"
                                            icon="fas fa-eye"
                                            @click.prevent="$dispatch('open-modal', 'project-view-{{ $project->id }}')"
                                        >
                                            View
                                        </x-action-button>

                                        @if (auth()->user()?->canWrite())
                                            <x-action-button
                                                href="{{ route('projects.edit', $project) }}"
                                                variant="edit"
                                                size="xs"
                                                icon="fas fa-pen"
                                                @click.prevent="$dispatch('open-modal', 'project-edit-{{ $project->id }}')"
                                            >
                                                Edit
                                            </x-action-button>
                                            <x-action-button
                                                variant="archive"
                                                size="xs"
                                                icon="fas fa-archive"
                                                @click.prevent="$dispatch('open-modal', 'project-archive-{{ $project->id }}')"
                                            >
                                                Archive
                                            </x-action-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 font-bold">No projects yet</p>
                <p class="text-slate-400 text-sm mt-1">Create your first project to get started</p>
                @if (auth()->user()?->canWrite())
                    <x-action-button
                        href="{{ route('projects.create') }}"
                        variant="create"
                        size="md"
                        class="mt-4"
                        @click.prevent="$dispatch('open-modal', 'project-create')"
                    >
                        Create
                    </x-action-button>
                @endif
            </div>
        @endif
    </div>

    @if (auth()->user()?->canWrite())
        <x-modal name="project-create" title="Create Project" subtitle="Add a new project to your agency">
            <form id="project-create-form" action="{{ route('projects.store') }}" method="POST" class="space-y-5">
                @csrf
                @include('pages.projects._form-fields')
            </form>

            @slot('footer')
                <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">
                    Cancel
                </x-action-button>
                <x-action-button type="submit" variant="create" size="sm" form="project-create-form">
                    Create
                </x-action-button>
            @endslot
        </x-modal>
    @endif

    @foreach ($projects as $project)
        <x-modal name="project-view-{{ $project->id }}" title="Project Details" subtitle="{{ $project->name }}">
            <div class="space-y-4 text-sm text-slate-600">
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

            @slot('footer')
                <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">
                    Close
                </x-action-button>
            @endslot
        </x-modal>

        @if (auth()->user()?->canWrite())
            <x-modal name="project-edit-{{ $project->id }}" title="Edit Project" subtitle="Update details for {{ $project->name }}">
                <form id="project-edit-form-{{ $project->id }}" action="{{ route('projects.update', $project) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    @include('pages.projects._form-fields', ['project' => $project])
                </form>

                @slot('footer')
                    <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">
                        Cancel
                    </x-action-button>
                    <x-action-button type="submit" variant="edit" size="sm" form="project-edit-form-{{ $project->id }}">
                        Save Changes
                    </x-action-button>
                @endslot
            </x-modal>

            <x-modal name="project-archive-{{ $project->id }}" title="Archive Project" subtitle="{{ $project->name }}">
                <div class="space-y-4 text-sm text-slate-600">
                    <p>
                        Archiving will hide this project from active lists. You can still view archived records later.
                    </p>
                    <div class="rounded-xl border border-rose-100 bg-rose-50 p-4 text-rose-700">
                        <p class="font-semibold">Are you sure you want to archive this project?</p>
                    </div>
                </div>

                <form id="project-archive-form-{{ $project->id }}" action="{{ route('projects.destroy', $project) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>

                @slot('footer')
                    <x-action-button type="button" variant="view" size="sm" @click.prevent="$dispatch('close-modal')">
                        Cancel
                    </x-action-button>
                    <x-action-button type="submit" variant="archive" size="sm" form="project-archive-form-{{ $project->id }}">
                        Archive
                    </x-action-button>
                @endslot
            </x-modal>
        @endif
    @endforeach
</div>
@endsection
