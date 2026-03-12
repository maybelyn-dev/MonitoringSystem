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
            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                <i class="fas fa-plus"></i> New Project
            </a>
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
                                <td class="py-4 px-4">{!! '₱' !!}{{ number_format($project->budget, 2) }}</td>
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
                                    <div class="flex gap-2">
                                        <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:text-blue-700 font-bold text-xs">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 font-bold text-xs">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
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
                <a href="{{ route('projects.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                    Create Project
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
