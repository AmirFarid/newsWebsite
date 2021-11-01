<?php

namespace App\Services;

use App\Models\Post;
use Carbon\Carbon;

class PostService
{

    public function create($request){

        $post = Post::firstOrCreate(
            $request->only(['title']),
            [
                'content' => $request->content,
                'publication_date' => $request->publication_date ??= Carbon::now(),
                'published' => $request->published ??= false
            ]
        );

        return $post;
    }

    public function addComment(){
        // TODO
    }

}
