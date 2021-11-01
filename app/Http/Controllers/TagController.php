<?php

namespace App\Http\Controllers;

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

    public function getPostByTag(){
        //        TODO
    }
}
