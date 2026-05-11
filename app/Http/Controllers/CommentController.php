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
    $comment = new Comment();
    $comment->user_id = Auth::id();
    $comment->serv_id = $serv->id;
    $comment->comment = $request->comment;
    $comment->parent_id = $request->parent_id ?? null;
    $comment->save();

    // Сохраняем до 3 фото
    if ($request->hasFile('photos')) {
        $files = $request->file('photos');
        $allowed = min(3, count($files));

        for ($i = 0; $i < $allowed; $i++) {
            $path = $files[$i]->store('comment-photos', 'public');
            $comment->photos()->create(['photo' => $path]);
        }
    }

$comment->load('user', 'photos');

return response()->json([
    'message' => 'ok',
    'comment' => $comment
    ]);
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
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
        return response()->json(['error' => 'нет прав'], 403);
    }

    $comment->delete();

    return response()->json(['message' => 'ok']);
    }
}
