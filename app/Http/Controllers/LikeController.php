<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLikeRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateLikeRequest;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        $isLike = false;
        $like=Like::where("post_id", $post->id)->where("user_id", Auth::id())->first();
        if($like)
            {
                $like->delete();

            }else{
                $like = New Like();
                $like -> post_id = $post->id;
                $like -> user_id = Auth::id();
                $like -> save();
                $isLike = true;
            }
        return response()->json(['like_count' => Like::where("post_id", $post->id)->count(),'isLike' => $isLike]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLikeRequest $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
