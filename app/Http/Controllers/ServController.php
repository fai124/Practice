<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Serv;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class ServController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servs = Serv::withCount("comments", "likes")->with("user")->paginate(1);
        // $populars = Post::withCount("comments", "likes")->with("user")->limit(1)->get();
        $populars = Serv::withCount('likes', 'comments')->with('user')->orderBy('likes_count', 'desc')->limit(4)->get();
        return response()->json(["servs" => $servs, 'populars' => $populars]);
    }

    public function servuser(User $user)
    {
        return Serv::where("user_id", $user->id)->withCount("comments", "likes")->with("user")->get();
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

    /**
     * Display the specified resource.
     */
    public function show($serv)
    {
        $serv = Serv::with('user')->withCount('likes', 'comments')->findOrFail($serv);
        $comments = Comment::with('user')->where('serv_id', $serv->id)->get();
        $isLike = false;
        $isAdmin = false;
        if((Auth::check())){
            $like=Like::where("serv_id", $serv->id)->where("user_id", Auth::id())->first();
            if($like){
                $isLike = true;
            }
            if(Auth::user()->id == $serv->user_id || Auth::user()->role =='admin'){
                $isAdmin = true;
            }
        }
        return response()->json(['serv' => $serv, 'comments' => $comments, 'isAdmin' => $isAdmin, 'isLike' => $isLike]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Serv $serv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Serv $serv)
    {
        $serv->delete();
          return response()->json(['message' => ":ok"]);
    }
}
