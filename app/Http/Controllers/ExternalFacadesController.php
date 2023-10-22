<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ExternalFacades;
use App\Http\Requests\StoreExternalFacadesRequest;
use App\Http\Requests\UpdateExternalFacadesRequest;

class ExternalFacadesController extends Controller
{


    public function index()
    {

        $allfacades = ExternalFacades::all();

        if ($allfacades == null) {
            return response()->json(['message' =>'Sorry facades not found'], 400);
        }

        foreach ($allfacades as $facade) {
            $facade->image = asset('storage/ExternalFacades/' . $facade->image);
        }
        return response()->json(['facades' => $allfacades], 200);
    }


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreExternalFacadesRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('ExternalFacades', $request->image);
        $imgname = basename($imgname);

        ExternalFacades::create([
            'image' => $imgname
        ]);


        return response()->json(['message' => 'Storage completed successfully'], 201);
    }


    public function destroy(Request $request)
    {
        $deletedfacade = ExternalFacades::find($request->idfacade);

        if ($deletedfacade == null) {
            return response()->json(['message' => 'This facade not found'], 404);
        }
        $path = 'ExternalFacades/' . $deletedfacade->image;
        Storage::delete($path);
        $deletedfacade->delete();

        return response()->json(['message' => 'facade deleted successfully'], 200);
    }
}
