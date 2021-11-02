<?php

namespace App\Services\Filter;

class SortASC implements Filterable
{

    public static function filter($model, $query, $constraint)
    {

        $query = $query->orderBy($constraint, 'asc');

        return $query;
    }
}
