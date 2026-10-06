<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PublicUserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ApiSearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $q = $request->query('q');

        $users = User::search($q)->orderBy('name')->limit(10)->get();

        $posts = Post::with('user:id,name')
            ->where('status', 'published')
            ->search($q)
            ->withCount(['comments', 'likes'])
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'users' => PublicUserResource::collection($users)->resolve(),
            'posts' => PostResource::collection($posts)->resolve(),
        ]);
    }
}