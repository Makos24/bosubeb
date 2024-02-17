<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserRoleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(Auth::user()->role_id == 4 && Auth::user()->agency_id != null){
                    $builder->where('category_id', 4)->where('agency_id', Auth::user()->agency_id);
                }elseif(Auth::user()->role_id == 3 && Auth::user()->agency_id != null){
                    $builder->where('category_id', 4)->where('agency_id', Auth::user()->agency_id);
                }elseif(Auth::user()->role_id == 2 && Auth::user()->lga_id != null){
                    $builder->whereIn('category_id', [1,2,3])->where('lga_id', Auth::user()->lga_id);
                }elseif(Auth::user()->role_id == 2){
                    $builder->whereIn('category_id', [1,2,3]);
                }elseif(Auth::user()->role_id == 3){
                    $builder->where('category_id', 4);
                }
    }
}
