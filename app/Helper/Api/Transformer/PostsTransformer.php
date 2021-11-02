<?php

namespace App\Helper\Api\Transformer;

use App\Models\Post;

class PostsTransformer implements Transformer
{

    public function handle($data, $param = null)
    {
//        dd($data);
        $transformedData = $data->getCollection()->map( function (Post $post){

            return [
                'id' => $post['id'],
                'text' => $post['content'],
                'update_at' => $post['update_at'],
                'tags' => ApiTransformer::transform(TagTransformer::class, $post->tags),
                'filterable_fields' => Post::$filterable
            ];
        });

        return $transformedData->all();
    }

}
