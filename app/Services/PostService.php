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

        $time = $request->publication_date ??= Carbon::now();


        $post = Post::firstOrCreate(
            $request->only(['title']),
            [
                'content' => $request->content,
                'publication_date' => $time,
                'created_at' => $time,
                'active' => $request->active ? true : false,
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

        $post = defaultFilter(Post::class , null);
        return FilterFacade::filter(Post::class,$post,[
            'searchNot' => ['mime_type' => 'podcast']
        ]);

    }

    public function indexPodcast(){

        $post = defaultFilter(Post::class , null);
        return FilterFacade::filter(Post::class,$post,[
            'search' => ['mime_type' => 'podcast']
        ]);

    }

    public function adminIndex(){

        return FilterFacade::filter(Post::class , null , [
            'sort' => ['ACS' => 'created_at']
        ]);

    }


    public function search($constraint){

        $posts = defaultFilter(Post::class , null);
        return FilterFacade::filter(Post::class , $posts , $constraint);

    }

    public function update(Request $request , Post $post){
        $post = $post->update($request->only('title','content','publication_date','created_at','mime_type'));
        if ($request->hasFile('media'))
            $post->media = $request->file('media');
        $post->save();

        return $post;
    }

    public function addComment(){
        // TODO
    }

}
