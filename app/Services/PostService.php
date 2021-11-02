<?php

namespace App\Services;

use App\Models\Post;
use App\Services\Filter\FilterFacade;
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

    public function index(){

        return defaultFilter(Post::class , null);

    }

    public function search($constraint){

        $posts = defaultFilter(Post::class , null);
        return FilterFacade::filter(Post::class , $posts , $constraint);

    }

    public function addComment(){
        // TODO
    }

}
