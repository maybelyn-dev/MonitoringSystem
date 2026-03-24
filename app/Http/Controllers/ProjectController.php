<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects for the authenticated user's agency
     */
    public function index()
    {
        $query = Project::query()
            ->with('agency')
            ->orderBy('created_at', 'desc');
        $projects = $query->paginate(10);

        return view('pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        return redirect()
            ->route('projects.index')
            ->with('open_modal', 'project-create');
    }

    /**
     * Store a newly created project in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:Planning,In Progress,Completed,On Hold,Cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $user = Auth::user();
        $agencyId = $user->agency_id ?? Agency::orderBy('id')->value('id');

        Project::create([
            'agency_id' => $agencyId,
            ...$validated,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Show the form for editing the specified project
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return redirect()
            ->route('projects.index')
            ->with('open_modal', "project-edit-{$project->id}");
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('pages.projects.show', compact('project'));
    }

    /**
     * Update the specified project in storage
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:Planning,In Progress,Completed,On Hold,Cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project archived successfully!');
    }
}
