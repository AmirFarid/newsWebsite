<?php

namespace App\Services;


use App\Models\Comment;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Client\Request;

class CommentService
{

    public function create(Request $request){

        $comment = Comment::firstOrCreate(
            $request->only(['title']),
            [
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'title' => $request->title,
                'content' => $request->content
            ]
        );

        return $comment;

    }

    public function index(Request $request){
        return FilterFacade::
        filter(Comment::class,null,['search' => ['post_id' => $request->post_id]]);
    }

}
