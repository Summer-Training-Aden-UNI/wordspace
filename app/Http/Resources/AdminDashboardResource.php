<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'users_count' => $this->users_count,
            'posts_count' => $this->posts_count,
            'published_posts' => $this->published_posts,
            'drafts' => $this->drafts,
            'comments_count' => $this->comments_count,
        ];
    }
}