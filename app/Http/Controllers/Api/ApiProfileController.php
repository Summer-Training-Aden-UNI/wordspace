<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
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

            'followers_count' => $user->followers()->count(),
                
        ],
    ]);
}

    public function update(Request $request)
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'username' => 'sometimes|nullable|string|max:30|unique:users,username,' . $user->id,
        'email' => 'sometimes|required|email|max:255|unique:users,email,' . $user->id,
        'bio' => 'sometimes|nullable|string|max:1000',
        'avatar' => 'sometimes|file|image|mimes:jpg,jpeg,png,webp|max:2048', 
    ], [
        'avatar.uploaded' => 'The avatar could not be uploaded. The file is larger than the server limit '
            . '(raise upload_max_filesize / post_max_size in php.ini).',
    ]);

    $user->fill(collect($validated)->only(['name', 'username', 'email', 'bio'])->all());

    $oldAvatar = $user->avatar;

    if ($request->hasFile('avatar')) {
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    } elseif ($request->boolean('remove_avatar')) {
        $user->avatar = null;
    }

    $user->save();

    // Delete the old file only after the DB update succeeded.
    if ($oldAvatar && $oldAvatar !== $user->avatar) {
        Storage::disk('public')->delete($oldAvatar);
    }

    return response()->json([
        'message' => 'Profile updated successfully.',
        'user' => new UserResource($user),
    ]);
}
}