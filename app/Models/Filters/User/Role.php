<?php

namespace App\Models\Filters\User;


use App\Services\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;


class Role implements Filterable
{

    public static function apply(Builder $builder, $value)
    {
        return $builder->whereHas('roles', function ($query) use ($value) {
            $query->where('roles.id', $value);
        });
    }
}
