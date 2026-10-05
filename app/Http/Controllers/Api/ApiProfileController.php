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

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:30|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ]);

        if ($request->has('name')) {
            $user->name = $validated['name'];
        }
        if (array_key_exists('username', $validated)) {
            $user->username = $validated['username'];
        }
        if ($request->has('email')) {
            $user->email = $validated['email'];
        }
        if (array_key_exists('bio', $validated)) {
            $user->bio = $validated['bio'];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        } elseif ($request->boolean('remove_avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => new UserResource($user),
        ]);
    }
}