<?php

namespace App\Services\Filter;



class Search implements Filterable
{

    static function filter($model, $query, $constraint){

        foreach ($constraint as $key => $value) {
                validateFilterableField($model , $key);
                $query = $query->where($key, $value);
            }

        return $query;

    }


}
