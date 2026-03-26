<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine if the user can view the project
     */
    public function view(User $user, Project $project): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the project
     */
    public function update(User $user, Project $project): Response|bool
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }
        if ($user->isFocalViewer()) {
            return Response::deny('403 Unauthorized: You can only modify data within your assigned province.');
        }
        if ($user->canManageProvinceName($project->agency?->province)) {
            return Response::allow();
        }
        return Response::deny('403 Unauthorized: You can only modify data within your assigned province.');
    }

    /**
     * Determine if the user can delete the project
     */
    public function delete(User $user, Project $project): Response|bool
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }
        if ($user->isFocalViewer()) {
            return Response::deny('403 Unauthorized: You can only modify data within your assigned province.');
        }
        if ($user->canManageProvinceName($project->agency?->province)) {
            return Response::allow();
        }
        return Response::deny('403 Unauthorized: You can only modify data within your assigned province.');
    }
}
