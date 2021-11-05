<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Transformer\CommentTransformer;
use App\Helper\Api\Validator\ApiValidator;
use App\Models\Comment;
use App\Services\CommentService;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{

    protected $service;

    public function __construct(CommentService $commentService)
    {
        $this->service = $commentService;
    }

    public function index(Request $request){

        ApiValidator::validate($request,[
            'post_id' => 'required'
        ]);

        $comments = $this->service->index($request)->paginate($request->per_page ??= 25);

        return jResponse()
            ->transform(CommentTransformer::class, $comments, true)
            ->toJson();

    }

    public function create(Request $request){

        ApiValidator::validate($request , [
            'user_id' => 'required',
            'post_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $comment = $this->service->create($request);

        return jResponse()
            ->setData(['id' => $comment->id])
            ->toJsonSuccess('Comment added successfully!');

    }

    public function update(Request $request, Comment $comment){

        $this->service->update($request,$comment);

        return jResponse()
            ->toJsonSuccess("Comment updated successfully");

    }

    public function delete(Comment $comment){

        $comment->delete();

        return jResponse()
            ->toJsonSuccess("Comment deleted successfully");
    }



}
