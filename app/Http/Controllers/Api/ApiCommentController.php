<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Post;

class ApiCommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->latest()
            ->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request, Post $post)
{
    $validated = $request->validate([
        'content' => 'required|string',
    ]);

    $comment = $post->comments()->create([
        'content' => $validated['content'],
        'user_id' => auth()->id(),
    ]);

    return (new CommentResource($comment))
        ->additional([
            'message' => 'Comment created successfully.',
        ])
        ->response()
        ->setStatusCode(201);
}

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully.',
        ]);
    }
}