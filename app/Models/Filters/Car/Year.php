<?php
/**
 * Created by PhpStorm.
 * User: note
 * Date: 01.02.2021
 * Time: 22:49
 */

namespace App\Models\Filters\Car;


use App\Services\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class Year implements Filterable
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('year', $value);
    }
}
