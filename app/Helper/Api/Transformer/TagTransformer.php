<?php

namespace App\Helper\Api\Transformer;

use App\Models\Tag;

class TagTransformer implements Transformer
{

    public function handle($data, $param = null)
    {
//        dd($data);
        $transformedData = $data->map( function (Tag $tag){

            return[

                'id' => $tag['id'],
                'name' => $tag['name']

            ];
        });

        return $transformedData->all();

    }
}
