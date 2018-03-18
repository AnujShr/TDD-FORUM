<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_memebers_can_avatars()
    {
       $this->withExceptionHandling();
        $this->json('POST','api/users/1/avatar')
        ->assertStatus(401);
    }

    function test_a_valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling()->signIn();
        $this->json('POST','api/users/'.auth()->id().'/avatar',['avatar' => 'not-an-image'])->assertStatus(422);

    }

    function test_may_add_avatar_at_their_profile()
    {
        $this->signIn();
        Storage::fake('public');
        $this->json('POST','api/users/'.auth()->id().'/avatar',[
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')]);
        $this->assertEquals(asset('storage/avatars/'.$file->hashName()),auth()->user()->avatar_path);
        Storage::disk('public')->assertExists('avatars/'.$file->hashName());
    }
}
