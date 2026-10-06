<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Like;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'username',
        'bio',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
    return $this->hasMany(Like::class);
    }

    public function followers(): BelongsToMany
{
    return $this->belongsToMany(
        User::class,
        'follows',
        'following_id',
        'follower_id'
    );
}

public function following(): BelongsToMany
{
    return $this->belongsToMany(
        User::class,
        'follows',
        'follower_id',
        'following_id'
    );
}

public function follow(User $user): void
{
    $this->following()->syncWithoutDetaching([$user->id]);
}

public function unfollow(User $user): void
{
    $this->following()->detach($user->id);
}

public function isFollowing(User $user): bool
{
    return $this->following()
        ->where('users.id', $user->id)
        ->exists();
}
    public function getAvatarUrlAttribute()
    {
    return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
{
    $term = ltrim(trim((string) $term), '@');   // allow "@john"

    if ($term === '') {
        return $query;
    }

    $like = '%' . addcslashes($term, '%_\\') . '%';

    return $query->where(function (Builder $q) use ($like) {
        $q->where('username', 'like', $like)
          ->orWhere('name', 'like', $like);
    });
}
}