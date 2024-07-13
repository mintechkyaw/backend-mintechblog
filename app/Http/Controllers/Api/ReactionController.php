<?php

namespace App\Http\Controllers\Api;

use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReactionResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reactions = Reaction::get();
        return  ReactionResource::collection($reactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Reaction $reaction)
    {
        $request->validate([
            'react_type' => [
                'required',
                'string',
                Rule::in(['like', 'love'])
            ],
            'post_id' => 'required|exists:posts,id'
        ]);


        $existReaction = Reaction::where('user_id', Auth::user()->id)
            ->where('post_id', $request->post_id)
            ->first();

        if ($existReaction) {

            $existReaction->react_type = $request->react_type;
            $existReaction->save();
        } else {
            $reaction->react_type = $request->react_type;
            $reaction->user_id = Auth::user()->id;
            $reaction->post_id = $request->post_id;
            $reaction->save();
        }

        return response()->json([
            'msg' => 'React success'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reaction $reaction)
    {
        return $reaction;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reaction $reaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reaction $reaction)
    {
        //
    }
}
