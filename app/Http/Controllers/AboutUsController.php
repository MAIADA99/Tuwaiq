<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreAboutUsRequest;
use App\Http\Requests\UpdateAboutUsRequest;

class AboutUsController extends Controller
{


    //showtoedit
    public function show(Request $request)
    {
        $data = AboutUs::find(1);

        $data->image = asset('storage/AboutUs/' . $data->image);
        //  $data->file = asset('storage/AboutUs/' . $data->file);
        return response()->json(['data' => $data], 200);
    }


    public function update(Request $request)
    {
        $data = AboutUs::find(1);

        $responvalidator = Validator::make($request->all(), (new UpdateAboutUsRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }


        if ($request->file('image') != null) {
            $pathimg = 'AboutUs/' . $data->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('AboutUs', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $data->image;
        }

        // if ($request->file('file') != null) {
        //     $pathimg = 'AboutUs/' . $data->file;
        //     Storage::delete($pathimg);
        //     $filename = Storage::putFile('AboutUs', $request->file);
        //     $filename = basename($filename);
        // } else {
        //     $filename = $data->file;
        // }


        $data->update([
            'name' => json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname,
            //  'file'=>$filename
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }



}
