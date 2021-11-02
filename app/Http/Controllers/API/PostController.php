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


        $posts = FilterFacade::filter(Post::class,null,['search' => ['published' => true]] );
        $posts = $posts->paginate($request->per_page ??= 25);

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
        return jResponse()->setData(['id' => $post->id])->toJsonSuccess('با موفقیت ذخیره شد!');
    }


    public function togglePublished(Post $post)
    {
        $post->togglePublished();
        return jResponse()->setData(['id' => $post->id])->toJsonSuccess('با موفقیت ذخیره شد!');
    }



}
