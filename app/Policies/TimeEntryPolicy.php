<?php

namespace App\Policies;

use App\Models\TimeEntry;
use App\Models\User;

class TimeEntryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_time_entries');
    }

    public function view(User $user, TimeEntry $timeEntry): bool
    {
        if ($user->id === $timeEntry->user_id) {
            return true;
        }
        return $user->hasPermission('view_all_time_entries') && $user->isProjectMember($timeEntry->project);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create_time_entries');
    }

    public function update(User $user, TimeEntry $timeEntry): bool
    {
        return $user->id === $timeEntry->user_id || $user->hasPermission('edit_all_time_entries');
    }

    public function delete(User $user, TimeEntry $timeEntry): bool
    {
        return $user->id === $timeEntry->user_id || $user->hasPermission('delete_all_time_entries');
    }
}
