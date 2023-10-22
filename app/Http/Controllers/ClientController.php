<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;


class ClientController extends Controller
{
    public function index()
    {

        $allclients = Client::all();

        if ($allclients == null) {
            return response()->json(['message'=>'Sorry Clients not found'], 400);
        }

        foreach ($allclients as $client) {
            $client->image = asset('storage/Clients/' . $client->image);
        }
        return response()->json(['Clients' => $allclients], 200);
    }


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreClientRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('Clients', $request->image);
        $imgname = basename($imgname);

        Client::create([
            'image' => $imgname
        ]);


        return response()->json(['message' => 'Storage completed successfully'], 201);
    }


    public function destroy($idclient)
    {
        $deletedclient = Client::find($idclient);

        if ($deletedclient == null) {
            return response()->json(['message' => 'This Client not found'], 404);
        }
        $path = 'Clients/' . $deletedclient->image;
        Storage::delete($path);
        $deletedclient->delete();

        return response()->json(['message' => 'clients deleted successfully'], 200);
    }
}
