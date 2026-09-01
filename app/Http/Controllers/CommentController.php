<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->route('posts.show', $comment->post_id)
            ->with('success', 'Comment deleted successfully.');
    }
}