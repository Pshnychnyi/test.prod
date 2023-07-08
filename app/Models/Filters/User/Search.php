<?php

namespace App\Models\Filters\User;

use App\Services\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;


class Search implements Filterable
{

    public static function apply(Builder $builder, $value)
    {
        return $builder->where(function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%')
                ->orWhere('lastname', 'like', '%' . $value . '%')
                ->orWhere('phone', 'like', '%' . $value . '%');
        });
    }
}
