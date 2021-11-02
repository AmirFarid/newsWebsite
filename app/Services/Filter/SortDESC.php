<?php

namespace App\Services\Filter;

class SortDESC implements Filterable
{

    public static function filter($model, $query, $constraint)
    {

        $query = $query->orderBy($constraint, 'desc');

        return $query;
    }
}
