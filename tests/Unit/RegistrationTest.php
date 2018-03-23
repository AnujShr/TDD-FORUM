<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confimation_email_is_sent_upon_registration()
    {
        Mail::fake();
        $this->post('/register', ['name' => 'John', 'email' => 'john@test.com', 'password' => 'foobar', 'password_confirmation' => 'foobar']);

        Mail::assertQueued(PleaseConfirmYourEmail::class);
    }

    function test_user_can_fully_confirm_email_address()
    {
        Mail::fake();
        $this->post(route('register'), ['name' => 'John', 'email' => 'john@test.com', 'password' => 'foobar', 'password_confirmation' => 'foobar']);
        $user = User::whereName('John')->first();
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))->assertRedirect(route('threads'));
        $this->assertTrue($user->fresh()->confirmed);

    }

    function test_confirming_an_invalid_token(){
        $this->get(route('register.confirm', ['token' => 'invalid']))
        ->assertRedirect(route('threads'))
        ->assertSessionHas('flash','Unknown token');
    }
}
