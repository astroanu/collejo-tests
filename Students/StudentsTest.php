<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\StudentRepository;
use Collejo\App\Models\StudentCategory;
use Collejo\App\Models\User;
use Collejo\App\Models\Student;
use Collejo\App\Models\Guardian;
use Collejo\App\Models\Batch;
use Collejo\App\Models\Grade;
use Collejo\App\Models\Clasis;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use DatabaseMigrations;

    private $studentRepository;

    public function testAssignGuardian()
    {
        factory(StudentCategory::class, 3)->create();

        $student = factory(User::class)->create()->student()->save(factory(Student::class)->make());
        $guardian = factory(User::class)->create()->guardian()->save(factory(Guardian::class)->make());

        $this->studentRepository->assignGuardian($guardian->id, $student->id);

        $this->assertTrue($this->studentRepository->findStudent($student->id)->guardians->contains($guardian->id));
    }

    public function testRemoveGuardian()
    {
        factory(StudentCategory::class, 3)->create();

        $student = factory(User::class)->create()->student()->save(factory(Student::class)->make());
        $guardian = factory(User::class)->create()->guardian()->save(factory(Guardian::class)->make());

        $this->studentRepository->assignGuardian($guardian->id, $student->id);

        $this->studentRepository->removeGuardian($guardian->id, $student->id);

        $this->assertFalse($this->studentRepository->findStudent($student->id)->guardians->contains($guardian->id));
    }

    public function testAssignToClass()
    {
        factory(StudentCategory::class, 3)->create();

        $student = factory(User::class)->create()->student()->save(factory(Student::class)->make());
        $batch = factory(Batch::class)->create();
        $grade = factory(Grade::class)->create();
        $class = factory(Clasis::class)->create(['grade_id' => $grade->id]);

        $this->studentRepository->assignToClass($batch->id, $grade->id, $class->id, false, $student->id);

        $this->assertTrue($this->studentRepository->findStudent($student->id)->classes->contains($class->id));
    }

    public function setup()
    {
        parent::setup();
        
        $this->studentRepository = $this->app->make(StudentRepository::class);
    }
}
