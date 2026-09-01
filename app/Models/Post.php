<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\like;
class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
    ];

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
