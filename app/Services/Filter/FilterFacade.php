<?php

namespace App\Services\Filter;

use \App\Services\Filter;

class FilterFacade implements Filterable
{
    static function filter($model, $query, $constraint){

        $query = querGetOrCreate($model, $query);

        foreach ($constraint as $key => $value){

            switch ($key){
                case 'sort':
                    return Sort::filter($model, $query, $value);
                case 'search':
                    return Search::filter($model, $query, $value);
                default:
                    // TODO
                    abort(400);

            }

        }
        return null;
    }
}
