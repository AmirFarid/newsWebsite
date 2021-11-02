<?php

namespace App\Services\Filter;

class SortGTDate implements Filterable
{

    public static function filter($model, $query, $constraint)
    {
        foreach ($constraint as $key => $value) {
            validateFilterableField($model , $key);
            $query = $query->whereDate($key, '>=', $value);
        }

        return $query;
    }
}
