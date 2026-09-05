<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\PostResource;

class ApiPostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->withcount(['comments', 'likes'])
            ->latest()
            ->get();

        return PostResource::collection($posts);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:draft,published',
    ]);

    $validated['user_id'] = auth()->id();

    $post = Post::create($validated);

    return (new PostResource($post))
    ->additional([
        'message' => 'Post created successfully.',
    ])
    ->response()
    ->setStatusCode(201);
}

public function update(Request $request, Post $post)
{
    if ($post->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized.',
        ], 403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:draft,published',
    ]);

    $post->update($validated);

    return (new PostResource($post))
    ->additional([
        'message' => 'Post updated successfully.',
    ]);
}
public function show(Post $post)
{
    $post->loadCount(['comments', 'likes']);
    return new PostResource($post);
}

public function destroy(Post $post)
{
    if ($post->user_id !== auth()->id()) {
        return response()->json([
            'message' => 'Unauthorized.',
        ], 403);
    }

    $post->delete();

    return response()->json([
        'message' => 'Post deleted successfully.',
    ]);
}

    
}