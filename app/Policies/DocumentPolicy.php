<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Legislation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class DocumentPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Document $document)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND $user->id === $document->legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND $user->id === $document->legislation->user_id) {
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
        $legislation = Legislation::find(request()->legislation_id);
        
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND $user->id === $legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND $user->id === $legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Document $document)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND $user->id === $document->legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND $user->id === $document->legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Document $document)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND $user->id === $document->legislation->institute->corrector_id) {
            $allows = true;
        } else if (Gate::allows('isOpd') AND $user->id === $document->legislation->user_id) {
            $allows = true;
        }

        return $allows;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }

    public function ratify(User $user, Document $document)
    {
        $allows = false;
        if (Gate::allows('isAdmin')) {
            $allows = true;
        } else if (Gate::allows('isBagianHukum') AND $user->id === $document->legislation->institute->corrector_id) {
            $allows = true;
        }

        return $allows;
    }
}
