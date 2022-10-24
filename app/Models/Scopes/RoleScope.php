<?php
 
namespace App\Models\Scopes;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
 
class RoleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->select(['legislations.*', 'institutes.abbrev AS institute_abbrev', 'institutes.name AS institute_name'])
            ->join('institutes', 'legislations.institute_id', '=', 'institutes.id');

        if (Gate::allows('isBagianHukum')) {
            $builder->where('institutes.corrector_id', Auth::user()->id);
        }

        if (Gate::allows('isOpd')) {
            $user_institute = Auth::user()->institutes->first();
            $builder->where('institutes.id', $user_institute->id);
        }
    }
}