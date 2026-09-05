<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminDashboardResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Http\Resources\UserResource;

class ApiAdminController extends Controller
{
    public function dashboard()
{
    $stats = (object) [
        'users_count' => User::count(),
        'posts_count' => Post::count(),
        'published_posts' => Post::where('status', 'published')->count(),
        'drafts' => Post::where('status', 'draft')->count(),
        'comments_count' => Comment::count(),
    ];

    return new AdminDashboardResource($stats);
}

    public function users()
    {
        $users = User::latest()->get();
        return UserResource::collection($users);
    }

public function destroyUser(User $user)
{
    if ($user->isAdmin()) {
        return response()->json([
            'message' => 'Admin users cannot be deleted.',
        ], 403);
    }

    $user->delete();

    return response()->json([
        'message' => 'User deleted successfully.',
    ]);
}
}