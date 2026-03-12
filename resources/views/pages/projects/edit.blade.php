@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('projects.index') }}" class="text-blue-600 font-bold text-sm hover:text-blue-700 mb-4 inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900">Edit Project</h1>
        <p class="text-slate-500 mt-2">Update project details</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[2rem] p-6 md:p-8 shadow-sm border border-blue-100 max-w-2xl">
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Project Name *</label>
                <input type="text" name="name" required value="{{ old('name', $project->name) }}"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter project name">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Enter project description">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Budget -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Budget (₱) *</label>
                <input type="number" name="budget" required value="{{ old('budget', $project->budget) }}" step="0.01" min="0"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="0.00">
                @error('budget')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Status *</label>
                <select name="status" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                    <option value="">-- Select Status --</option>
                    <option value="Planning" {{ old('status', $project->status) == 'Planning' ? 'selected' : '' }}>Planning</option>
                    <option value="In Progress" {{ old('status', $project->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="On Hold" {{ old('status', $project->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                    <option value="Cancelled" {{ old('status', $project->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('start_date')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('end_date')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Progress -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Progress (%)</label>
                <input type="number" name="progress" value="{{ old('progress', $project->progress) }}" min="0" max="100"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="0">
                @error('progress')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    Update Project
                </button>
                <a href="{{ route('projects.index') }}" class="flex-1 bg-slate-100 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-200 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
