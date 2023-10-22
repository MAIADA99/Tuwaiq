<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;

class SliderController extends Controller
{

    public function index()
    {
        $allsliders = Slider::all();

        if ($allsliders == null) {
            return response()->json(['message' => 'Sliders is empty'], 400);
        }

        foreach ($allsliders as $slider) {
            $slider->image = asset('storage/Slider/' . $slider->image);
        }
        return response()->json(['allsliders' => $allsliders], 200);
    }


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreSliderRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('Slider', $request->image);
        $imgname = basename($imgname);


        Slider::create([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }

    //showoredit
    public function edit(Request $request)
    {
        $Slider = Slider::find($request->id);

        if ($Slider == null) {
            return response()->json(['message'=>'Slider doesn\'t exist'], 404);
        }

        $Slider->image = asset('storage/Slider/' . $Slider->image);

        return response()->json(['Slider' => $Slider], 200);
    }


    public function update(Request $request)
    {
        $slider = Slider::find($request->id);

        if ($slider == null) {
            return response()->json(['message' => 'Slider doesn\'t exist'], 404);
        }

        $responvalidator = Validator::make($request->all(), (new UpdateSliderRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }


        if ($request->file('image') != null) {
            $pathimg = 'Slider/' . $slider->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('Slider', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $slider->image;
        }

        $slider->update([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }


    public function destroy(Request $request)
    {
        $deletedslider = Slider::find($request->id);

        if ($deletedslider == null) {
            return response()->json(['message' => 'This Slider not found'], 404);
        }
        $path = 'Slider/' . $deletedslider->image;
        Storage::delete($path);
        $deletedslider->delete();

        return response()->json(['message' => 'Slider deleted successfully'], 200);
    }
}
