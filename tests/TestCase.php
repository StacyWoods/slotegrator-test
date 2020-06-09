<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function signIn(?User $user = null)
    {
        $user = $user ?: create(User::class);

        return $this->actingAs($user);
    }

    protected function signOut()
    {
        Auth::logout();

        return $this;
    }
}
