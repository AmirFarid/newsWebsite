<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Transformer\PostsTransformer;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Request;
use App\Helper\Api\Transformer\TagTransformer;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(){

        return jResponse()
            ->transform( TagTransformer::class ,Tag::all())
            ->toJson();

    }

    public function getPostByTag(Request $request){

        // TODO sort filter should be complete
        $posts = FilterFacade::filter(Post::class , Tag::findOrFail($request->id)->posts(),[]);
        $posts = $posts->paginate($request->per_page ??= 25);

        return jResponse()
            ->transform(PostsTransformer::class , $posts)
            ->toJson();
    }

    public function assignTag(){



    }
}
