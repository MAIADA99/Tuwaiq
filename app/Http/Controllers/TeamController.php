<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    //admin+homeaboutus
    public function index()
    {
        $allteam = Team::all();

        if ($allteam == null) {
            return response()->json(['message' => 'Data is empty'], 400);
        }

        foreach ($allteam as $person) {
            $person->image = asset('storage/Team/' . $person->image);
        }
        return response()->json(['allteam' => $allteam], 200);
    }


    //for admin
    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreTeamRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('Team', $request->image);
        $imgname = basename($imgname);


        Team::create([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }

    //foradmin for edit

    public function edit(Request $request)
    {

        $oneperson = Team::find($request->id);

        if ($oneperson == null) {
            return response()->json(['message' => 'This person doesn\'t exist'], 404);
        }

        $oneperson->image = asset('storage/Team/' . $oneperson->image);

        return response()->json(['oneperson' => $oneperson], 200);
    }

    //for admin
    public function update(Request $request)
    {
        $oneperson = Team::find($request->id);

        if ($oneperson == null) {
            return response()->json(['message' => 'This person doesn\'t exist'], 404);
        }

        $responvalidator = Validator::make($request->all(), (new UpdateTeamRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 422);
        }


        if ($request->file('image') != null) {
            $pathimg = 'Team/' . $oneperson->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('Team', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $oneperson->image;
        }

        $oneperson->update([
            'title' => json_encode(['ar' => $request->title_ar, 'en' => $request->title_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }
    //for admin
    public function destroy(Request $request)
    {
        $deletedperson = Team::find($request->id);

        if ($deletedperson == null) {
            return response()->json(['message' => 'This person not found'], 404);
        }
        $path = 'Team/' . $deletedperson->image;
        Storage::delete($path);
        $deletedperson->delete();

        return response()->json(['message' => 'Person deleted successfully'], 200);
    }
}
