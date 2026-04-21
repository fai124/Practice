<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($commentId) 
    {
        $comment = Comment::findOrFail($commentId);
        
        $isLike = false;
        $like = Like::where("comment_id", $comment->id)
            ->where("user_id", Auth::id())
            ->first();
            
        if ($like) {
            $like->delete();
        } else {
            $like = new Like();
            $like->comment_id = $comment->id;
            $like->user_id = Auth::id();
            $like->save();
            $isLike = true;
        }
        
        $likesCount = Like::where("comment_id", $comment->id)->count();
        
        return response()->json([
            'like_count' => $likesCount,
            'isLike' => $isLike
        ]);
    }
}