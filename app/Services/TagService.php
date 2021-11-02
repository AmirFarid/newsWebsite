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
           'search' => ['published' => true],
           'sort' => ['STDate' => ['publication_date' => Carbon::now()]]
       ]);

    }
}
