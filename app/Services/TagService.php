<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use App\Services\Filter\FilterFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TagService
{

    public function create(Request $request){

        return Tag::firstOrCreate(
            $request->only('name')
        );

    }

    public function getPostByTag(Tag $tag){

       return FilterFacade::filter(Post::class , $tag->posts(),[
           'search' => ['active' => true],
           'sort' => [
               'STDate' => ['publication_date' => Carbon::now()],
               'ACS' => 'created_at']
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
