<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::withCount("comments", "likes")->with("user")->paginate(1);
        // $populars = Post::withCount("comments", "likes")->with("user")->limit(1)->get();
        $populars = Post::withCount('likes', 'comments')->with('user')->orderBy('likes_count', 'desc')->limit(4)->get();
        return response()->json(["posts" => $posts, 'populars' => $populars]);
    }

    public function postuser(User $user)
    {
        return Post::where("user_id", $user->id)->withCount("comments", "likes")->with("user")->get();
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
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->user_id = Auth::id();
        $post->name = $request->name;
        $post->subtitle = $request->subtitle;
        $post->anons = $request->anons;
        $post->content = $request->content;
        $path = Storage::disk("public")->putFile("photos", $request->file("photo"));
        $post->photo = $path;
        $post->save();
        return response()->json(['id' => $post->id]);

    }

    /**
     * Display the specified resource.
     */
    public function show($post)
    {
        $post = Post::with('user')->withCount('likes', 'comments')->findOrFail($post);
        $comments = Comment::with('user')->where('post_id', $post->id)->get();
        $isLike = false;
        $isAdmin = false;
        if((Auth::check())){
            $like=Like::where("post_id", $post->id)->where("user_id", Auth::id())->first();
            if($like){
                $isLike = true;
            }
            if(Auth::user()->id == $post->user_id || Auth::user()->role =='admin'){
                $isAdmin = true;
            }
        }
        return response()->json(['post' => $post, 'comments' => $comments, 'isAdmin' => $isAdmin, 'isLike' => $isLike]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->name = $request->name;
        $post->subtitle = $request->subtitle;
        $post->anons = $request->anons;
        $post->content = $request->content;
        if($request->has("photo")){
        $path = Storage::disk("public")->putFile("photos", $request->file("photo"));
        $post->photo = $path;
        }
        $post->save();
        return response()->json(['id' => $post->id]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
          return response()->json(['message' => ":ok"]);
    }
}
