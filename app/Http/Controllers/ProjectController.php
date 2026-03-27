<?php

namespace App\Http\Controllers;

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
        $user = Auth::user();
        $projects = Project::query()
            ->when(!$user->isSuperAdmin(), function ($query) use ($user) {
                $query->where('agency_id', $user->agency_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        if (Auth::user()->isSuperAdmin()) {
            abort(403, 'Super Admin accounts cannot create new projects.');
        }

        return view('pages.projects.create');
    }

    /**
     * Store a newly created project in storage
     */
    public function store(Request $request)
    {
        if (Auth::user()->isSuperAdmin()) {
            abort(403, 'Super Admin accounts cannot create new projects.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:Planning,In Progress,Completed,On Hold,Cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        Project::create([
            'agency_id' => Auth::user()->agency_id,
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
        return view('pages.projects.edit', compact('project'));
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
