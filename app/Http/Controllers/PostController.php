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
        //check if user authorized or not
        $posts = Posts::where('user_id', Auth::id())->get();
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the incoming http request 
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        //create a new post with eloquent 
        $post = posts::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        //return response in api with json
        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $post)
    {
        //show one single post with id 
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {
        //check if user is authorized or not
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'User is not authorized'], 403);

        }
        //validate incoming http request
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);
        //update post with eloquent
        $post->update($validated);
        //return response in api with Json
        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post)
    {
        //check the user is authorized or not
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'User is not authorized'], 403);
        }

        $post->delete();

        //return repsonse in api with json
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
