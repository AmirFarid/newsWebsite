<?php

namespace App\Services;


use App\Models\Category;
use App\Models\Post;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Request;

class CategoryService
{

    public function create(Request $request){

        return Category::firstOrCreate(
            $request->only('name'),
            [
                'is_parent' => $request->parent_id ? false : true,
                'category_id' => $request->parent_id ? $request->parent_id : null,
            ]
        );

    }

    public function update(Request $request , Category $category){
        return $category->update($request->only('name','is_parent','category_id'));
    }

    public function getPostByCategory($id){

        $post = defaultFilter(Post::class, null);
        return FilterFacade::filter(Post::class,$post,[
            'search' => ['category_id' => $id]
        ]);
    }

}
