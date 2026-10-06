<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiFollowController extends Controller
{
    public function store(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'You cannot follow yourself.',
            ], 422);
        }

        $request->user()->follow($user);

        $user->loadCount('followers');

        return response()->json([
            'is_following' => true,
            'followers_count' => $user->followers_count,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json([
                'message' => 'You cannot unfollow yourself.',
            ], 422);
        }

        $request->user()->unfollow($user);

        $user->loadCount('followers');

        return response()->json([
            'is_following' => false,
            'followers_count' => $user->followers_count,
        ]);
    }
}