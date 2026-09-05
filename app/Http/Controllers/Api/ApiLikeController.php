<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class ApiLikeController extends Controller
{
    public function index(Post $post)
{
    $user = auth()->user();

    $likeCount = Like::where('post_id', $post->id)->count();

    $likedByMe = Like::where('post_id', $post->id)
        ->where('user_id', $user->id)
        ->exists();

    return response()->json([
        'post_id' => $post->id,
        'likes_count' => $likeCount,
        'liked_by_me' => $likedByMe,
    ]);
}


    public function store(Post $post)
    {
        $user = auth()->user();

        $existingLike = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            return response()->json([
                'message' => 'You already liked this post.',
            ], 409);
        }

        $like = Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return response()->json([
            'message' => 'Post liked successfully.',
            'like' => $like,
        ], 201);
    }

    public function destroy(Post $post)
    {
    $user = auth()->user();

    $like = Like::where('user_id', $user->id)
        ->where('post_id', $post->id)
        ->first();

    if (!$like) {
        return response()->json([
            'message' => 'You have not liked this post.',
        ], 404);
    }

    $like->delete();

    return response()->json([
        'message' => 'Post unliked successfully.',
    ]);
    }
}