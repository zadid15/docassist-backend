<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return in_array($user->role, ['admin', 'doctor', 'nurse'])
            ? Response::allow()
            : Response::deny('You do not have permission to view appointments data.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, ['admin', 'nurse'])
            ? Response::allow()
            : Response::deny('You do not have permission to create appointments data.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return in_array($user->role, ['admin', 'nurse'])
            ? Response::allow()
            : Response::deny('You do not have permission to update appointments data.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return in_array($user->role, ['admin', 'nurse'])
            ? Response::allow()
            : Response::deny('You do not have permission to delete appointments data.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        return false;
    }
}
