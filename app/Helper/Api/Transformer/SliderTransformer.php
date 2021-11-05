<?php

namespace App\Helper\Api\Transformer;

use App\Models\Slider;

class SliderTransformer implements Transformer{

    public function handle($data, $param = null)
    {
        $transformedData = $data->map(function (Slider $slider){

            return [

                'id' => $slider['id'],
                'url' => $slider['url'],
                'image' => $slider->image->url(),
                'name' => $slider['name']

            ];

        });

        return $transformedData->all();

    }
}
