<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('assignments.view.any')
            || $user->can('assignments.view.own')
            || $user->isStudent();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.view.any')
            || ($user->can('assignments.view.own')
                && $assignment->course->instructor?->user_id === $user->id)
            || $assignment->course->enrollments()
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('assignments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.edit.any')
            || ($user->can('assignments.edit.own')
                && $assignment->course->instructor?->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.delete.any')
            || ($user->can('assignments.delete.own')
                && $assignment->course->instructor?->user_id === $user->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.delete.any');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.delete.any');
    }
}
