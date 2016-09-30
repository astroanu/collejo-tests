<?php

namespace Tests\Auth;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\StudentRepository;
use Collejo\App\Models\User;
use Collejo\App\Models\Student;
use Collejo\App\Models\StudentCategory;
use Tests\TestCase;
use Auth;

class AuthStudentTest extends TestCase
{
    use DatabaseMigrations;

    private $studentRepository;

    public function testStudentCreate()
    {
        $user = factory(User::class)->make();
        $student = factory(Student::class)->make();

        $model = $this->studentRepository->createStudent(array_merge($user->toArray(), $student->toArray()));

        $this->assertArrayValuesEquals($model, $student);
    }

    public function testStudentUpdate()
    {
        $student = factory(User::class)->create()->student()->save(factory(Student::class)->make());

        $studentNew = factory(Student::class)->make();
        $userNew = factory(Student::class)->make();

        $data = array_merge($userNew->toArray(), $studentNew->toArray());

        $model = $this->studentRepository->updateStudent($data, $student->id);

        $this->assertArrayValuesEquals($model, $data);
    }

    public function testStudentLogin()
    {
        $user = factory(User::class)->create();
        $student = factory(Student::class)->create(['user_id' => $user->id]);

        $result = Auth::attempt(['email' => $student->user->email, 'password' => '123']);

        $this->assertTrue($result);
    }

    public function setup()
    {
        parent::setup();
        
        $this->studentRepository = $this->app->make(StudentRepository::class);

        factory(StudentCategory::class, 3)->create();
    }
}
