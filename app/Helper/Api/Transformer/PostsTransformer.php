<?php

namespace App\Helper\Api\Transformer;

use App\Models\Post;

class PostsTransformer implements Transformer
{
    public function handle($data, $param = null)
    {
        $tranformedData = $data->getCollection()->map( function (Post $post) {

            return [
                'id' => $post['id'],
                'text' => $post['content'],
                'update_at' => $post['update_at'],
                'filterable_fields' => Post::$filterable
            ];
        });

        return $tranformedData->all();
    }

}
