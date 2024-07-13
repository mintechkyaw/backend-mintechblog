<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments =  Comment::get();
        return  CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:3000'],
            'post_id' => ['required', 'integer']
        ]);

        $comment->comment = $request->comment;
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->save();
        return  response()->json([
            'msg' => "Comment Success"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
