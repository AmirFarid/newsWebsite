<?php

namespace App\Services;

use App\Models\User;

use App\Services\Filter\FilterFacade;
use Carbon\Carbon;

function defaultFilter($model, $query){
    return FilterFacade::filter($model, $query, [

        'search' => ['active' => true],
        'sort' => [

            'STDate' => [
                'publication_date' => Carbon::now(),
                ],

            'ACS' => 'created_at'
        ]
    ]);
}
