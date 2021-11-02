<?php

namespace App\Helper\Api\Transformer;

use App\Models\Comment;

class CommentTransformer implements Transformer
{
    public function handle($data, $param = null)
    {
        $transformedData = $data->map( function (Comment $comment){
            return [

                "id" => $comment['id'],
                "content" => $comment['content']

            ];
        });

        return $transformedData->all();
    }
}
