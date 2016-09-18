<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\GuardianRepository;
use Collejo\App\Models\User;
use Collejo\App\Models\Guardian;
use Tests\TestCase;
use Auth;

class GuardianUserTest extends TestCase
{
    use DatabaseMigrations;

    private $guardianRepository;

    public function testGuardianCreate()
    {
        $user = factory(User::class)->make();
        $guardian = factory(Guardian::class)->make();

        $model = $this->guardianRepository->createGuardian(array_merge($user->toArray(), $guardian->toArray()));

        $this->assertArrayValuesEquals($model, $guardian);
    }

    public function testGuardianUpdate()
    {
        $guardian = factory(User::class)->create()->guardian()->save(factory(Guardian::class)->make());

        $guardianNew = factory(Guardian::class)->make();
        $userNew = factory(Guardian::class)->make();

        $data = array_merge($userNew->toArray(), $guardianNew->toArray());

        $model = $this->guardianRepository->updateGuardian($data, $guardian->id);

        $this->assertArrayValuesEquals($model, $data);
    }

    public function testGuardianLogin()
    {
        $user = factory(User::class)->create();
        $guardian = factory(Guardian::class)->create(['user_id' => $user->id]);

        $result = Auth::attempt(['email' => $guardian->user->email, 'password' => '123']);

        $this->assertTrue($result);
    }

    public function setup()
    {
        parent::setup();
        
        $this->guardianRepository = $this->app->make(GuardianRepository::class);
    }
}
