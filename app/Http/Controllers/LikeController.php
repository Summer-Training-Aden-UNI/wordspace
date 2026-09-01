<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $existingLike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if (!$existingLike) {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
        }

        return redirect()
            ->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->delete();

        return redirect()
            ->route('posts.show', $post);
    }
}