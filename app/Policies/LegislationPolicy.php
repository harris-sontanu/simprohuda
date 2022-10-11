<?php

namespace App\Policies;

use App\Models\Legislation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class LegislationPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND Auth::user()->institutes->first()->id === $legislation->institute_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND Auth::user()->id === $legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND Auth::user()->id === $legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND Auth::user()->id === $legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND Auth::user()->id === $legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    public function approve(User $user, Legislation $legislation)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND Auth::user()->id === $legislation->institute->corrector_id) {
            $allows = true;
        }

        return $allows;
    }
}
