<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Serv;
use Illuminate\Support\Facades\Auth;
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
    public function store(StoreCommentRequest $request, Serv $serv,)
    {
        $comment = New Comment();
        $comment->user_id = Auth::id();
        $comment->serv_id = $serv->id;
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent_id ?? null;
        $comment->save();
        return response()->json(['message' => 'ok', 'comment' => $comment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
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
