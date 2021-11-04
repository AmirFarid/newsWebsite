<?php

namespace App\Helper\Api\Transformer;

use App\Models\Slider;

class SliderTransformer implements Transformer{

    public function handle($data, $param = null)
    {
        $transformedData = $data->getCollection()->map(function (Slider $slider){

            return [

                'url' => $slider['url'],
                'image' => $slider->image->url(),
                'name' => $slider['name']

            ];

        });

        return $transformedData->all();

    }
}
