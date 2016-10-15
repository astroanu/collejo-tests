<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\StudentRepository;
use Collejo\App\Models\StudentCategory;
use Tests\TestCase;

class StudentCategoryTest extends TestCase
{
    use DatabaseMigrations;

    private $studentRepository;

    public function testStudentCategoryCreate()
    {
        $studentCategory = factory(StudentCategory::class)->make();

        $model = $this->studentRepository->createStudentCategory($studentCategory->toArray());

        $this->assertArrayValuesEquals($model, $studentCategory);
    }

    public function testStudentCategoryUpdate()
    {
        $studentCategory = factory(StudentCategory::class)->create();

        $studentCategoryNew = factory(StudentCategory::class)->make();

        $model = $this->studentRepository->updateStudentCategory($studentCategoryNew->toArray(), $studentCategory->id);

        $this->assertArrayValuesEquals($model, $studentCategoryNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->studentRepository = $this->app->make(StudentRepository::class);
    }
}
