<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    // Skip registration tests since your app doesn't have user registration
    public function test_registration_screen_can_be_rendered(): void
    {
        $this->markTestSkipped('User registration is not implemented in this application.');
    }

    public function test_new_users_can_register(): void
    {
        $this->markTestSkipped('User registration is not implemented in this application.');
    }
}
