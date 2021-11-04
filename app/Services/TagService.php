<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use App\Services\Filter\FilterFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TagService
{
    public function getPostByTag(Request $request){

       return FilterFacade::filter(Post::class , Tag::findOrFail($request->id)->posts(),[
           'search' => ['active' => true],
           'sort' => ['STDate' => ['publication_date' => Carbon::now()]]
       ]);

    }

    public function unAssignTag(Request $request, Post $post){

        foreach ($request->tags_id as $tag){
            $post->tags()->detach($tag);
        }

    }

    public function assignTag(Request $request, Post $post){
        $post->tags()->sync($request->tags_id);
    }
}
