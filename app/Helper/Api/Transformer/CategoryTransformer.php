<?php

namespace App\Helper\Api\Transformer;

use App\Models\Category;

class CategoryTransformer implements Transformer{

    public function handle($data, $param = null)
    {
        $transformedData = $data->map(function (Category $category){

            return [
                'id' => $category['id'],
                'name' => $category['name']
            ];
        });

        return $transformedData->all();
    }
}
