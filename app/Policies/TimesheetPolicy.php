<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Timesheet;
use App\Models\User;

class TimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Timesheet $timesheet)
    {
        switch ($user->role) {
            case 1:
                return true;
            case 2:
                if ($user->id === $timesheet->user_id)
                    return true;
                elseif ($user->id === $timesheet->manager_id)
                    return true;
                else
                    return false;
            case 0:
                if ($user->id === $timesheet->user_id)
                    return true;
                else
                    return 0;
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Timesheet $timesheet)
    {
        return $user->id === $timesheet->user_id;
    }

    //approve timesheet
    //role: 1 - admin, 2 - manager
    public function updateStatus(User $user, Timesheet $timesheet)
    {
        return $user->role === 1 || ($user->role === 2 && $user->id === $timesheet->manager_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Timesheet $timesheet)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Timesheet $timesheet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Timesheet $timesheet)
    {
        //
    }
}
