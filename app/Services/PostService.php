<?php

namespace App\Services;

use App\Models\Multimedia;
use App\Models\Post;
use App\Services\Filter\FilterFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostService
{

    public function create($request){

        $post = Post::firstOrCreate(
            $request->only(['title']),
            [
                'content' => $request->content,
                'publication_date' => $request->publication_date ??= Carbon::now(),
                'active' => $request->active ??= false,
                'mime_type' => $request->hasFile('media') ? $request->mime_type : null
            ]
        );

        $this->createMedia($request, $post);

        return $post;
    }

    public function createMedia(Request $request,Post $post){

        if ($request->hasFile('media')) {
            $media = Multimedia::create([
                'post_id' => $post->id
            ]);
            $media->media = $request->file('media');
            $media->save();
        }

    }

    public function index(){

        return defaultFilter(Post::class , null);

    }

    public function search($constraint){

        $posts = defaultFilter(Post::class , null);
        return FilterFacade::filter(Post::class , $posts , $constraint);

    }

    public function addComment(){
        // TODO
    }

}
