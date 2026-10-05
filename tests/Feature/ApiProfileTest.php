<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class ApiProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_avatar()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->postJson('/api/profile', [
            'avatar' => $file,
        ]);

        $response->assertStatus(200);
        
        $user->refresh();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        
        $response->assertJson([
            'user' => [
                'avatar_url' => Storage::disk('public')->url($user->avatar),
            ]
        ]);
    }

    public function test_can_remove_avatar()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'avatars/test.jpg'
        ]);

        $response = $this->actingAs($user)->postJson('/api/profile', [
            'remove_avatar' => true,
        ]);

        $response->assertStatus(200);
        
        $user->refresh();
        $this->assertNull($user->avatar);
        
        $response->assertJson([
            'user' => [
                'avatar_url' => null,
            ]
        ]);
    }
    
    public function test_uploaded_avatar_takes_precedence_over_remove()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avatar' => 'avatars/old.jpg'
        ]);

        $file = UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->postJson('/api/profile', [
            'remove_avatar' => true,
            'avatar' => $file,
        ]);

        $response->assertStatus(200);
        
        $user->refresh();
        $this->assertNotNull($user->avatar);
        $this->assertNotEquals('avatars/old.jpg', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        
        $response->assertJson([
            'user' => [
                'avatar_url' => Storage::disk('public')->url($user->avatar),
            ]
        ]);
    }
}
