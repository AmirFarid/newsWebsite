<?php

namespace App\Services;


use App\Models\Comment;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Request;

class CommentService
{

    public function create(Request $request){

        $comment = Comment::firstOrCreate(
            $request->only(['title']),
            [
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'content' => $request->text,
                'title' => $request->title,

            ]
        );

        return $comment;

    }

    public function index(Request $request){
        return FilterFacade::
        filter(Comment::class,null,['search' => ['post_id' => $request->post_id]]);
    }

    public function update(Request $request, Comment $comment){

        return $comment->update($request->only('content','title'));

    }

}
