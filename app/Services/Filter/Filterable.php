<?php

namespace App\Services\Filter;

interface Filterable{
    public static function filter($model, $query, $constraint);
}
