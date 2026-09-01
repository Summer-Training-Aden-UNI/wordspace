<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $postsCount = Post::count();
        $commentsCount = Comment::count();
        $usersCount = User::count();

        $recentPosts = Post::with('user')
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        $recentComments = Comment::with(['user', 'post'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'postsCount',
            'commentsCount',
            'usersCount',
            'recentPosts',
            'recentUsers',
            'recentComments'
        ));
    }
    public function posts()
    {
        $posts = Post::with('user')
            ->latest()
            ->get();

        return view('admin.posts', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
    $this->authorize('delete', $post);

    $post->delete();

    return redirect()
        ->route('admin.posts')
        ->with('success', 'Post deleted successfully.');
    }

    public function comments()
{
    $comments = Comment::with(['user', 'post'])
        ->latest()
        ->get();

    return view('admin.comments', compact('comments'));
}

    public function destroyComment(Comment $comment)
    {
    $this->authorize('delete', $comment);

    $comment->delete();

    return redirect()
        ->route('admin.comments')
        ->with('success', 'Comment deleted successfully.');
    }

    public function users()
{
    $users = User::latest()->get();

    return view('admin.users', compact('users'));
}

    public function destroyUser(User $user)
    {
    if ($user->id === auth()->id()) {
        abort(403, 'You cannot delete your own account.');
    }

    $user->delete();

    return redirect()
        ->route('admin.users')
        ->with('success', 'User deleted successfully.');
    }
}