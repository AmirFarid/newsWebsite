<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Transformer\PostsTransformer;
use App\Helper\Api\Validator\ApiValidator;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Filter\FilterFacade;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Helper\Api\Transformer\TagTransformer;
use App\Models\Tag;

class TagController extends Controller
{
    protected $service;
    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    public function index(){

        return jResponse()
            ->transform( TagTransformer::class ,Tag::all())
            ->toJson();

    }

    public function getPostByTag(Request $request){

        // TODO sort filter should be complete
        $posts = $this->service->getPostByTag($request)->paginate($request->per_page ??= 25);

        return jResponse()
            ->transform(PostsTransformer::class , $posts)
            ->toJson();
    }

    public function create(Request $request){
        ApiValidator::validate($request , [
            'name' => 'required'
        ]);

        $tag = $this->service->create($request);

        return jResponse()
            ->setDate('id' , $tag->id)
            ->toJsonSuccess('Tag added successfully');

    }

    public function assignTag(){



    }
}
