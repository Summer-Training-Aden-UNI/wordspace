<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiPostController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
        ]);

        $posts = Post::with('user:id,name')          
            ->where('status', 'published')
            ->search($request->query('search'))      
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // NEW (2 MB)
        ]);

        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);
        $post->load('user:id,name')->loadCount(['comments', 'likes']);

        return (new PostResource($post))
            ->additional(['message' => 'Post created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'sometimes|file|image|mimes:jpg,jpeg,png,webp|max:2048', 
            //'remove_image' => 'nullable|boolean',                          
        ]);

        
        $data = collect($validated)->except(['image', 'remove_image'])->all();

        if ($request->hasFile('image')) {
            // new image replaces the old one
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        } elseif ($request->boolean('remove_image')) {
            
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = null;
        }

        $post->update($data);
        $post->load('user:id,name')->loadCount(['comments', 'likes']);

        return (new PostResource($post))
            ->additional(['message' => 'Post updated successfully.']);
    }

    public function show(Request $request, Post $post)
    {
    // Drafts are private: only their author can open them.
    if ($post->status !== 'published' && $request->user('sanctum')?->id !== $post->user_id) {
        return response()->json(['message' => 'Post not found.'], 404);
    }

    $post->load('user:id,name')->loadCount(['comments', 'likes']);

    return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }

    public function likedPosts(Request $request)
{
    $userId = $request->user()->id;

    $posts = Post::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with('user:id,name')
        ->withCount(['comments', 'likes'])
        ->latest()
        ->paginate(10);

    $posts->getCollection()->each(function ($post) {
        $post->liked_by_me = true;
    });

    return PostResource::collection($posts);
}
}