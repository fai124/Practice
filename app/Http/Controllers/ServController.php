<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Serv;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServController extends Controller
{
    public function index()
    {
        $servs = Serv::with('user')->paginate(4);
        $populars = Serv::with('user')->limit(4)->get();
        $isAdmin = false;
        if (Auth::check() && Auth::user()->role === 'admin') {
        $isAdmin = true;
        }
        return response()->json(["servs" => $servs, 'populars' => $populars, "isAdmin" => $isAdmin]);
    }

    public function servuser(User $user)
    {
        return Serv::where("user_id", $user->id)->with("user")->get();
    }

    public function store(StoreServRequest $request)
    {
        $serv = new Serv();
        $serv->user_id = Auth::id();
        $serv->name = $request->name;
        $serv->content = $request->content;
        $path = Storage::disk("public")->putFile("photos", $request->file("photo"));
        $serv->photo = $path;
        $serv->save();
        return response()->json(['id' => $serv->id]);
    }

    public function show($serv)
    {
        $serv = Serv::with('user')->findOrFail($serv);

        $comments = Comment::with(['user', 'replies' => function($q) {
         $q->with('user');
       }, 'photos'])
         ->where('serv_id', $serv->id)
         ->whereNull('parent_id')
         ->get();
        

        foreach ($comments as $comment) {
            $comment->likes_count = Like::where('comment_id', $comment->id)->count();
            
            if (Auth::check()) {
                $comment->is_liked = Like::where('comment_id', $comment->id)
                    ->where('user_id', Auth::id())
                    ->exists();
            } else {
                $comment->is_liked = false;
            }
        }
        
        $isAdmin = false;
        if(Auth::check()){
            if(Auth::user()->role == 'admin'){
                $isAdmin = true;
            }
        }
        
        return response()->json([
            'serv' => $serv, 
            'comments' => $comments, 
            'isAdmin' => $isAdmin
        ]);
    }
}