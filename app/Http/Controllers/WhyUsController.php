<?php

namespace App\Http\Controllers;

use App\Models\WhyUs;
use App\Http\Requests\StoreWhyUsRequest;
use App\Http\Requests\UpdateWhyUsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WhyUsController extends Controller
{
    //admin+homeaboutus
    public function index()
    {
        $allwhyus = WhyUs::all();

        if ($allwhyus == null) {
            return response()->json(['message' => 'WhyUs is empty'], 400);
        }

        foreach ($allwhyus as $why) {
            $why->image = asset('storage/WhyUs/' . $why->image);
        }
        return response()->json(['allwhyus' => $allwhyus], 200);
    }


//for admin
    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreWhyUsRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('WhyUs', $request->image);
        $imgname = basename($imgname);


        WhyUs::create([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }

   //foradmin for edit

    public function edit(Request $request)
    {

        $whyusone = WhyUs::find($request->id);

        if ($whyusone == null) {
            return response()->json(['message'=>'WhyUs doesn\'t exist'], 404);
        }

        $whyusone->image = asset('storage/WhyUs/' . $whyusone->image);

        return response()->json(['whyusone' => $whyusone], 200);
    }

    //for admin
    public function update(Request $request)
    {
        $WhyUs = WhyUs::find($request->id);

        if ($WhyUs == null) {
            return response()->json(['message' => 'WhyUs doesn\'t exist'], 404);
        }

        $responvalidator = Validator::make($request->all(), (new UpdateWhyUsRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }


        if ($request->file('image') != null) {
            $pathimg = 'WhyUs/' . $WhyUs->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('WhyUs', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $WhyUs->image;
        }

        $WhyUs->update([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_ar]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }
     //for admin
    public function destroy(Request $request)
    {
        $deleteddata = WhyUs::find($request->id);

        if ($deleteddata == null) {
            return response()->json(['message' => 'This data not found'], 404);
        }
        $path = 'WhyUs/' . $deleteddata->image;
        Storage::delete($path);
        $deleteddata->delete();

        return response()->json(['message' => 'Data deleted successfully'], 200);
    }
}
