<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\UserRepository;
use Collejo\App\Models\User;
use Tests\TestCase;
use Auth;

class AdminUserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private $userRepository;

    public function testUserCreate()
    {
        $user = factory(User::class)->make();

        $model = $this->userRepository->createAdminUser($user->first_name, $user->email, '123');

        $this->assertArrayValuesEquals($model, $user);
    }

    public function testUserLogin()
    {
        $user = factory(User::class)->make();

        $model = $this->userRepository->createAdminUser($user->first_name, $user->email, '123');

        $result = Auth::attempt(['email' => $user->email, 'password' => '123']);

        $this->assertTrue($result);
    }

    public function setup()
    {
        parent::setup();
        
        $this->userRepository = $this->app->make(UserRepository::class);
    }
}
