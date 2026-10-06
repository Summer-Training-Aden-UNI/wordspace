<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PublicUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function index(Request $request)
{
    $request->validate([
        'search' => 'required|string|min:2|max:100',
    ]);

    $users = User::search($request->query('search'))
        ->orderBy('username')
        ->paginate(20);

    return PublicUserResource::collection($users);
}
    public function show(Request $request, User $user)
    {
        $user->loadCount([
            'followers',
            'following',
        ]);

        $user->loadCount([
            'posts as posts_count' => function ($query) {
                $query->where('status', 'published');
            },
        ]);

        $data = [
            'user' => new PublicUserResource($user),
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
            'posts_count' => $user->posts_count,
        ];

        $authenticatedUser = $request->user('sanctum');

        if ($authenticatedUser) {
            $data['is_following'] = $authenticatedUser->isFollowing($user);
        }

        return response()->json($data);
    }

    public function posts(User $user)
    {
        $posts = $user->posts()
            ->where('status', 'published')
            ->with('user:id,name')
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return PostResource::collection($posts);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()
            ->latest()
            ->paginate(20);

        return PublicUserResource::collection($followers);
    }

    public function following(User $user)
    {
        $following = $user->following()
            ->latest()
            ->paginate(20);

        return PublicUserResource::collection($following);
    }
}