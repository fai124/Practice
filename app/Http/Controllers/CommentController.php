<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Serv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
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
    public function store(StoreCommentRequest $request, Serv $serv)
    {
        $comment = New Comment();
        $comment->user_id = Auth::id();
        $comment->serv_id = $serv->id;
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id ?? null;
        $comment->save();
        $comment->load('user');
        return response()->json(['message' => 'ok', 'comment' => $comment]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StoreCommentRequest $request,Comment $comment, Serv $serv)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Comment $comment)
    {
        if(Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'нет прав'], 403);
        }
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json(['message' => 'ok', 'comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
