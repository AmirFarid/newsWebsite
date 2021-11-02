<?php

namespace App\Services\Filter;

class SortSTDate implements Filterable
{

    public static function filter($model, $query, $constraint)
    {
        foreach ($constraint as $key => $value) {
            validateFilterableField($model , $key);
            $query = $query->whereDate($value, '>=', $key);
        }

        return $query;
    }
}
