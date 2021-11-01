<?php

namespace App\Services\Filter;

function validateFilterableField($model , $key){
    abort_if(in_array(!$key, $model::$filterable) , 400, "This field $key is an invalid searchable option");
}

function querGetOrCreate($model , $query){
    return ($query != null)? $query : new $model;
}

