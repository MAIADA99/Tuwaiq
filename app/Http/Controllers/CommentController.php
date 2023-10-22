<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{


    public function store(Request $request)
    {
        $responvalidator = Validator::make($request->all(), (new StoreCommentRequest)->rules());

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        Comment::create([
            'blog_id' => $request->blog_id,
            'comments' => $request->comments,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Storage completed successfully'], 201);
    }


    public function destroy(Request $request)
    {
        $deletedcomment = Comment::find($request->idcomment);
        if ($deletedcomment == null) {
            return response()->json(['message' => 'This Comment not found'], 404);
        }
        $deletedcomment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
