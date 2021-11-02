<?php

namespace App\Services\Filter;

use \App\Services\Filter;

class SortFacade implements Filterable
{
    static function filter($model, $query, $constraint){

        $query = querGetOrCreate($model, $query);

        foreach ($constraint as $key => $value){

            switch ($key){
                case 'GT':
                    return SortGT::filter($model, $query, $value);
                case 'GTDate':
                    return SortGTDate::filter($model, $query, $value);
                case 'GTorE':
                    return SortGTOrEqual::filter($model, $query, $value);
                case 'ACS':
                    return SortASC::filter($model, $query, $value);
                case 'DESC':
                    return SortDESC::filter($model, $query, $value);
                default:
                    abort(400);
            }

        }
        return null;
    }
}
