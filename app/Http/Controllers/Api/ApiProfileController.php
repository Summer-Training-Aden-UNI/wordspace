<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ApiProfileController extends Controller
{
    public function show(Request $request)
{
    $user = $request->user();

    return response()->json([
        'user' => new UserResource($user),

        'stats' => [
            'posts_count' => $user->posts()->count(),

            'published_posts' => $user->posts()
                ->where('status', 'published')
                ->count(),

            'drafts' => $user->posts()
                ->where('status', 'draft')
                ->count(),

            'comments_count' => $user->posts()
                ->withCount('comments')
                ->get()
                ->sum('comments_count'),

            'likes_count' => $user->posts()
                ->withCount('likes')
                ->get()
                ->sum('likes_count'),
        ],
    ]);
}


}