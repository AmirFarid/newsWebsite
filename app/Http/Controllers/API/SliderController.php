<?php

namespace App\Http\Controllers\API;

use App\Helper\Api\Validator\ApiValidator;
use App\Models\Slider;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\SlideService;
use App\Helper\Api\Transformer\SliderTransformer;

class SliderController extends Controller{

    protected $service;
    public function __construct(SlideService $service)
    {
        $this->service = $service;
    }

    public function index(){

        $slide = $this->service->index()->get();

        return jResponse()
            ->transform(SliderTransformer::class, $slide)
            ->toJson();

    }

    public function create(Request $request){

        ApiValidator::validate($request,
        [
            'url' => 'required',
            'name' => 'required'
        ]);

        $this->service->create($request);

        return jResponse()
            ->toJsonSuccess("slide added successfully");
    }

    public function delete(Slider $slider){

        $slider->delete();
        return jResponse()->toJsonSuccess("Slider deleted successfully");

    }

}
