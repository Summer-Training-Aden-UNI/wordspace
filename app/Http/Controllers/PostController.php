<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
     {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        Post::create($validated);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

    return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function dashboard()
    {
        if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    $publishedPosts = auth()->user()
        ->posts()
        ->where('status', 'published')
        ->latest()
        ->get();

    $draftPosts = auth()->user()
        ->posts()
        ->where('status', 'draft')
        ->latest()
        ->get();

    return view('dashboard', compact(
        'publishedPosts',
        'draftPosts'
    ));
    }
    public function myWriting()
    {    
    $publishedPosts = auth()->user()
        ->posts()
        ->where('status', 'published')
        ->latest()
        ->get();

    $draftPosts = auth()->user()
        ->posts()
        ->where('status', 'draft')
        ->latest()
        ->get();

    return view('my-writing', compact(
        'publishedPosts',
        'draftPosts'
    ));
    }
}
