<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_projects');
    }

    public function view(User $user, Project $project): bool
    {
        return $user->hasPermission('view_projects') && $user->isProjectMember($project);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create_projects');
    }

    public function update(User $user, Project $project): bool
    {
        return $user->isProjectManager($project) || $user->hasPermission('manage_all_projects');
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->owner_id || $user->hasPermission('manage_all_projects');
    }

    public function manageMembers(User $user, Project $project): bool
    {
        return $user->isProjectManager($project);
    }
}
