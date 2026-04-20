<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Serv;
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
    public function store(Serv $serv)
    {
        $isLike = false;
        $like=Like::where("serv_id", $serv->id)->where("user_id", Auth::id())->first();
        if($like)
            {
                $like->delete();

            }else{
                $like = New Like();
                $like -> serv_id = $serv->id;
                $like -> user_id = Auth::id();
                $like -> save();
                $isLike = true;
            }
        return response()->json(['like_count' => Like::where("serv_id", $serv->id)->count(),'isLike' => $isLike]);
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
