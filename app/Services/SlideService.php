<?php

namespace App\Services;

use App\Models\Slider;
use App\Services\Filter\FilterFacade;
use Illuminate\Http\Request;

class SlideService{

    public function index(){

        return FilterFacade::filter(Slider::class, null, [
            'sort' => ['ACS' => 'weight']
        ]);

    }

    public function create(Request $request){

        $slide = Slider::firstOrCreate(
            $request->only('name'),
            [
                'link' => $request->url,
            ]
        );

        $slide->image = $request->file('image');
        $slide->save();

        return $slide;
    }



}
