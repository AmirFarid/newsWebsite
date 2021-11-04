<?php

namespace App\Http\Controllers\API;

use App\Models\Slider;
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

        $slide = $this->service->index();

        return jResponse()
            ->transform(SliderTransformer::class, $slide)
            ->toJson();

    }

    public function delete(Slider $slider){

        $slider->delete();
        return jResponse()->toJsonSuccess("Slider deleted successfully");

    }

}
