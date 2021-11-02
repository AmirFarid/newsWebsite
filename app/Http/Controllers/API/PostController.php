<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Validator\ApiValidator;
use App\Services\Filter\FilterFacade;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helper\Api\Transformer\PostsTransformer;
use App\Models\Post;

class PostController extends Controller
{

    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request){

        $posts = $this->service->index()->paginate($request->per_page ??= 25);


        return jResponse()
            ->transform(PostsTransformer::class, $posts, true)
            ->toJson();

    }

    public function create(Request $request)
    {
        ApiValidator::validate($request, [
            'title' => 'required', 'content' => 'required'
        ]);

        $post = $this->service->create($request);

        return jResponse()->setData(['id' => $post->id])->toJsonSuccess('Post added successfully');
    }

    public function search(Request $request){
        ApiValidator::validate($request,
        [
            'constraint' => 'required'
        ]);

        $posts = $this->service->search($request->constraint)->paginate($request->per_page ??= 25);

        return jResponse()
            ->transform(PostsTransformer::class, $posts, true)
            ->toJson();
    }


    public function togglePublished(Post $post)
    {
        $message = $post->togglePublished();

        return jResponse()
            ->setData(['id' => $post->id])
            ->toJsonSuccess($message.' successfully!');
    }



}
