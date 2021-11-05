<?php

namespace App\Helper\Api\Transformer;

use App\Models\Post;

class PostsTransformer implements Transformer
{

    public function handle($data, $param = null)
    {

        $transformedData = $data->getCollection()->map( function (Post $post){

            return [
                'id' => $post['id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'update_at' => $post['update_at'],
                'tags' => ApiTransformer::transform(TagTransformer::class, $post->tags),
                'media' => ApiTransformer::transform(MultimediaTransformer::class, $post->multiMedias),
                'filterable_fields' => Post::$filterable,
                'publication_date' => $post['publication_date']
            ];
        });

        return $transformedData->all();
    }

}
