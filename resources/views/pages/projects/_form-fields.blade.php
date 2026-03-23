@php
    $project = $project ?? null;
@endphp

<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Project Name *</label>
    <input type="text" name="name" required value="{{ old('name', $project?->name) }}"
           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
           placeholder="Enter project name">
    @error('name')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
    <textarea name="description" rows="4"
              class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter project description">{{ old('description', $project?->description) }}</textarea>
    @error('description')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Budget (â‚±) *</label>
    <input type="number" name="budget" required value="{{ old('budget', $project?->budget) }}" step="0.01" min="0"
           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
           placeholder="0.00">
    @error('budget')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Status *</label>
    <select name="status" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
        <option value="">-- Select Status --</option>
        <option value="Planning" {{ old('status', $project?->status) == 'Planning' ? 'selected' : '' }}>Planning</option>
        <option value="In Progress" {{ old('status', $project?->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
        <option value="Completed" {{ old('status', $project?->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="On Hold" {{ old('status', $project?->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
        <option value="Cancelled" {{ old('status', $project?->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
    @error('status')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', $project?->start_date?->format('Y-m-d')) }}"
               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('start_date')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">End Date</label>
        <input type="date" name="end_date" value="{{ old('end_date', $project?->end_date?->format('Y-m-d')) }}"
               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        @error('end_date')
            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Progress (%)</label>
    <input type="number" name="progress" value="{{ old('progress', $project?->progress ?? 0) }}" min="0" max="100"
           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
           placeholder="0">
    @error('progress')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
