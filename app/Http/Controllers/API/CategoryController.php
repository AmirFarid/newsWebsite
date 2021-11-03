<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Transformer\CategoryTransformer;
use App\Helper\Api\Transformer\PostsTransformer;
use App\Helper\Api\Validator\ApiValidator;
use App\Services;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return jResponse()
            ->transform(CategoryTransformer::class,Category::all())
            ->toJson();
    }

    public function create(Request $request){
        ApiValidator::validate($request,[
            'name' => 'required',
        ]);

        $category = $this->service->create($request);

        return jResponse()
            ->setDate(['id' => $category->id])
            ->toJsonSuccess("Category Added successfully");


    }

    public function update(Request $request , Category $category){

        $response = $this->service->update($request,$category);

        return jResponse()
            ->setDate(['id' => $response->id])
            ->toJsonSuccess("Category updated successfully");

    }

    public function delete(Category $category){

        $category->delete();
        return jResponse()->toJsonSuccess("Category deleted successfully");

    }

    public function getPostByCategory(Request $request){
        ApiValidator::validate($request,[
            'category_id' => 'required'
        ]);

        $post = $this->service->getPostByCategory($request->category_id)->paginate($request->per_page ??= 25);

        return jResponse()
            ->transform(PostsTransformer::class, $post, true)
            ->toJson();
    }

}
