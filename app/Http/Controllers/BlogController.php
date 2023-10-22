<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{

    public function index()
    {

        $alldata = Blog::latest()->get();

        if ($alldata == null) {
            return response()->json(['message' => 'Sorry Websitedata not found'], 400);
        }

        foreach ($alldata as $data) {
            $data->image = asset('storage/Blog/' . $data->image);
        }

        return response()->json(['data' => $alldata], 200);
    }


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreBlogRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        $imgname = Storage::putfile('Blog', $request->image);
        $imgname = basename($imgname);

        Blog::create([
            'name' => json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }

    //show ->for a user +admin(it will also help admin to delete comment on certain blog) or edit on blog
    public function show(Request $request)
    {
        //blog+comments
        $blog = Blog::with('comments')->find($request->id);

        if ($blog == null) {
            return response()->json(['message'=>'Data doesn\'t exist'], 404);
        }

        $blog->image = asset('storage/Blog/' . $blog->image);


        $CommentsCount = count($blog->comments);

        return response()->json(['blog' => $blog, 'count' => $CommentsCount], 200);
    }


    public function update(Request $request)
    {
        $data = Blog::find($request->id);

        if ($data == null) {
            return response()->json(['message' => 'Data doesn\'t exist'], 404);
        }

        $responvalidator = Validator::make($request->all(), (new UpdateBlogRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }


        if ($request->file('image') != null) {
            $pathimg = 'Blog/' . $data->image;
            Storage::delete($pathimg);
            $imgname = Storage::putFile('Blog', $request->image);
            $imgname = basename($imgname);
        } else {
            $imgname = $data->image;
        }

        $data->update([
            'name' => json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]),
            'description' => json_encode(['ar' =>  $request->description_ar, 'en' => $request->description_en]),
            'image' => $imgname
        ]);

        return response()->json(['message' => 'Modified successfully'], 200);
    }

    public function destroy(Request $request)
    {
        $deleteddata = Blog::find($request->id);

        if ($deleteddata == null) {
            return response()->json(['message' => 'This data not found'], 404);
        }
        $path = 'Blog/' . $deleteddata->image;
        Storage::delete($path);
        $deleteddata->delete();

        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
}
