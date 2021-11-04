<?php

namespace App\Helper\Api\Transformer;

use App\Models\Category;

class CategoryTransformer implements Transformer{

    public function handle($data, $param = null)
    {
        $transformedData = $data->map(function (Category $category){

            $subCategory = $this->handleChild($category);

            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'is_parent' => $category->is_parent,
                'sub_cat' => $subCategory
            ];
        });

        return $transformedData->all();
    }

    private function handleChild($category){

        if ($category->is_parent){
            return [ApiTransformer::transform(CategoryTransformer::class, $category->child)];
        }
        return [];

    }

}
