<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;          
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',                                   
        'status',
        'user_id',
    ];

    // runs automatically whenever a post is deleted
    protected static function booted(): void
    {
        static::deleted(function (Post $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }

    
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%' . addcslashes($term, '%_\\') . '%';

        return $query->where(function (Builder $q) use ($like) {
            $q->where('title', 'like', $like)
              ->orWhere('content', 'like', $like);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}