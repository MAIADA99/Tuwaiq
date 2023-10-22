<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManufacturingVedio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreManufacturingVedioRequest;
use App\Http\Requests\UpdateManufacturingVedioRequest;

class ManufacturingVedioController extends Controller
{

    public function index()
    {
        $ManufacturingVediosandcovers = ManufacturingVedio::all();

        if ($ManufacturingVediosandcovers == null) {
            return response()->json(['message' => 'Sorry videos not found'], 400);
        }


        foreach ($ManufacturingVediosandcovers as $ManufacturingVedioandcover) {
            $ManufacturingVedioandcover->vedio = asset('storage/ManufacturingVedioandcover/' . $ManufacturingVedioandcover->id . '/' . $ManufacturingVedioandcover->vedio);
            $ManufacturingVedioandcover->cover = asset('storage/ManufacturingVedioandcover/' . $ManufacturingVedioandcover->id . '/' . $ManufacturingVedioandcover->cover);
        }

        return response()->json(['videosandcovers' => $ManufacturingVediosandcovers], 200);
    }



    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreManufacturingVedioRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

       //l2ny mosh 73rf ageb a5er id (7ta law etmsa7 l2n byrg3 a5er wa7ed in d.b) so i will put id manuwally
       //and savedit as numberof folder here firstly and id this record in database to be equal
           $ManufacturingVediosandcoverid = ManufacturingVedio::max('id')??0;
            $preIncrementedId = $ManufacturingVediosandcoverid + 1;

            // return $preIncrementedId;
            $ManufacturingFolder = 'ManufacturingVedioandcover/' . $preIncrementedId . '/';


        $vedioname = Storage::putFile($ManufacturingFolder, $request->vedio);
        $vedioname = basename($vedioname);
        $covername = Storage::putFile($ManufacturingFolder, $request->cover);
        $covername = basename($covername);

        ManufacturingVedio::create([
            'id'=>$preIncrementedId ,
            'vedio' => $vedioname,
            'cover' => $covername
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }



    public function destroy(Request $request)
    {
        $deletedvedio = ManufacturingVedio::find($request->id);

        if ($deletedvedio == null) {
            return response()->json(['message' => 'This vedio not found'], 404);
        }

        $path = 'ManufacturingVedioandcover/' . $deletedvedio->id . '/';

        Storage::deleteDirectory($path);

        $deletedvedio->delete();

        return response()->json(['message' => 'Vedio deleted successfully'], 200);
    }
}
