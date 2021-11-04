<?php

namespace App\Helper\Api\Transformer;

use App\Models\Multimedia;

class MultimediaTransformer implements Transformer{

    public function handle($data, $param = null)
    {
        return $data->map(function (Multimedia $media) {

            return [
                'media' => $media->url(),
                'type' => $media['media_content_type']
            ];

        });
    }
}
