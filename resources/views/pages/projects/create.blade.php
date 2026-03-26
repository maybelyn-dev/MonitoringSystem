@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-8">
        <x-action-button href="{{ route('projects.index') }}" variant="view" size="sm" icon="fas fa-arrow-left" class="mb-4">
            Back to Projects
        </x-action-button>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900">Create New Project</h1>
        <p class="text-slate-500 mt-2">Add a new project to your agency</p>
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

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
            @csrf

            @include('pages.projects._form-fields')

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <x-action-button type="submit" variant="create" size="md" class="flex-1">
                    Create Project
                </x-action-button>
                <x-action-button href="{{ route('projects.index') }}" variant="view" size="md" class="flex-1">
                    Cancel
                </x-action-button>
            </div>
        </form>
    </div>
</div>
@endsection
