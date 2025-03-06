<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Posts::where('user_id',Auth::id())->get();
        return response()->json($posts,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'content'=>'required|string'
        ]);
        $post=posts::create([
            'user_id'=>Auth::id(),
            'title'=>$request->title,
            'content'=>$request->content,
        ]);
        return response()->json([
            'message'=>'Post created successfully',
            'post'=>$post,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {
      if($post->user_id!==Auth::id()){
        return response()->json(['message'=>'User is not authorized'],403);

      } 
      $validated=$request->validate([
        'title'=>'sometimes|string|max:255',
        'content'=>'sometimes|string',
      ]); 
      $post->update($validated);
      return response()->json(['message'=>'Post updated successfully','post'=>$post],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'User is not authorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
