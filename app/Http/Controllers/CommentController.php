<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
class CommentController extends Controller
{
    public function index($postId)
    {
        //check is the post related to comment is found or not 
        $post = Posts::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        //retrieve all comments related to post id 
        $comments = Comments::where('post_id', $postId)->get();


        //return response in api with json 
        return response()->json([
            'comments' => $comments,
        ], 200);
    }

    public function store(Request $request, Posts $post)
    {
        //validate incoming http request
        $request->validate([
            'content' => 'required|string',
        ]);

        //create a new comment using eloquent 
        $comment = comments::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Comment Added Successfully',
            'comment' => $comment,
        ], 201);
    }
    public function show(Comments $comment)
    {

        //return one single comment 
        return response()->json([
            'comment' => $comment,
        ], 200);
    }

    public function update(Request $request, Comments $comment)
    {
        //check if user is authorized or not
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'User is not authorized',
            ], 403);
        }
        //validation of incoming http request
        $validated = $request->validate([
            'content' => 'sometimes|string',

        ]);
        //update comment with eloquent
        $comment->update($validated);
        return response()->json([
            'message' => 'Comment Updated Successfully',
            'comment' => $comment,
        ], 200);

    }

    public function destroy(Comments $comment)
    {
        //check if user is authorized or not
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'User is not authorized'], 403);
        }

        $comment->delete();
        //return respons in api with json
        return response()->json([
            'message' => 'Comment Deleted Successfully',
        ], 200);

    }

}
