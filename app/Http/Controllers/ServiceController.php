<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{

    public function index()
    {
        $allservice = Service::all();

        if ($allservice == null) {
            return response()->json(['message' => 'Service is empty'], 400);
        }

        foreach ($allservice as $service) {
            $service->image = asset('storage/Service/' . $service->image);
        }
        return response()->json(['service' => $allservice], 200);
    }


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreServiceRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('Service', $request->image);
        $imgname = basename($imgname);

        Service::create([
            'name' => json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }

    //show+edit
    public function show(Request $request)
    {

        $service = Service::find($request->id);

        if ($service == null) {
            return response()->json(['message'=>'Service doesn\'t exist'], 404);
        }

        $service->image = asset('storage/Service/' . $service->image);

        return response()->json(['service' => $service], 200);
    }

    public function update(Request $request)
    {
        $service = Service::find($request->id);

        if ($service == null) {
            return response()->json(['message' => 'Sevice doesn\'t exist'], 404);
        }

        $responvalidator = Validator::make($request->all(), (new UpdateServiceRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }


        if ($request->file('image') != null) {
            $pathimg = 'Service/' . $service->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('Service', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $service->image;
        }

        $service->update([
            'name' => json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }



    public function destroy(Request $request)
    {
        $deletedservice = Service::find($request->id);

        if ($deletedservice == null) {
            return response()->json(['message' => 'This Service not found'], 404);
        }
        $path = 'Service/' . $deletedservice->image;
        Storage::delete($path);
        $deletedservice->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}
