<?php

namespace App\Policies;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class InstitutePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if (Gate::any(['isAdmin', 'isBagianHukum'])) return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Institute $institute)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if (Gate::allows('isAdmin')) return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Institute $institute)
    {
        if (Gate::allows('isAdmin') OR $institute->corrector_id === Auth::user()->id) return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Institute $institute)
    {
        if (Gate::allows('isAdmin')) return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Institute $institute)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Institute $institute)
    {
        //
    }
}
