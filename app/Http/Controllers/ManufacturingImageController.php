<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ManufacturingImage;
use App\Http\Requests\StoreManufacturingImageRequest;
use App\Http\Requests\UpdateManufacturingImageRequest;

class ManufacturingImageController extends Controller
{

    public function index()
    {
        $Manufacturingimages = ManufacturingImage::all();

        if ($Manufacturingimages == null) {
            return response()->json(['message' => 'Sorry images not found'], 400);
        }

        foreach ($Manufacturingimages as $Manufacturingimage) {
            $Manufacturingimage->image = asset('storage/ManufacturingImage/' . $Manufacturingimage->image);
        }

        return response()->json(['images' => $Manufacturingimages], 200);
    }

    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreManufacturingImageRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putFile('ManufacturingImage', $request->image);
        $imgname = basename($imgname);

        ManufacturingImage::create([
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }


    public function destroy(Request $request)
    {
        $deletedimage = ManufacturingImage::find($request->id);

        if ($deletedimage == null) {
            return response()->json(['message' => 'This Image not found'], 404);
        }
        $path = 'ManufacturingImage/' . $deletedimage->image;
        Storage::delete($path);
        $deletedimage->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
