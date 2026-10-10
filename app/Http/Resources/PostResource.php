<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Public routes have no auth middleware, so read the Sanctum guard
        // directly. This works whether or not a token was sent.
        $viewer = $request->user('sanctum');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'author' => $this->whenLoaded('user', function () use ($request, $viewer) {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'avatar_url' => $this->user->avatar_url,
                    'is_following' => in_array(
                        $this->user->id,
                        $this->followingIds($request, $viewer),
                        true
                    ),
                ];
            }),
            'comments_count' => $this->comments_count,
            'likes_count' => $this->likes_count,
            'liked_by_user' => in_array(
                $this->id,
                $this->likedPostIds($request, $viewer),
                true
            ),
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /** IDs of the posts the viewer liked (one query per request). */
    private function likedPostIds(Request $request, $viewer): array
    {
        if (! $viewer) {
            return [];
        }

        return $this->cached($request, 'liked_post_ids', fn () =>
            $viewer->likes()->pluck('post_id')->all()
        );
    }

    /** IDs of the users the viewer follows (one query per request). */
    private function followingIds(Request $request, $viewer): array
    {
        if (! $viewer) {
            return [];
        }

        return $this->cached($request, 'following_ids', fn () =>
            $viewer->following()->pluck('users.id')->all()
        );
    }

    private function cached(Request $request, string $key, callable $load): array
    {
        if (! $request->attributes->has($key)) {
            $request->attributes->set($key, $load());
        }

        return $request->attributes->get($key);
    }
}