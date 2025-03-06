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
        $post = Posts::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }


        $comments = Comments::where('post_id', $postId)->get();

        return response()->json([
            'comments' => $comments,
        ], 200);
    }

    public function store(Request $request, Posts $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
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
        return response()->json([
            'comment' => $comment,
        ], 200);
    }

    public function update(Request $request, Comments $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'User is not authorized',
            ], 403);
        }
        $validated = $request->validate([
            'content' => 'sometimes|string',

        ]);
        $comment->update($validated);
        return response()->json([
            'message' => 'Comment Updated Successfully',
            'comment' => $comment,
        ], 200);

    }

    public function destroy(Comments $comment)
    {

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'User is not authorized'], 403);
        }

        $comment->delete();
        return response()->json([
            'message' => 'Comment Deleted Successfully',
        ], 200);

    }

}
