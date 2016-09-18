<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\ClassRepository;
use Collejo\App\Models\Grade;
use Tests\TestCase;

class GradeTest extends TestCase
{
    use DatabaseMigrations;

    private $classRepository;

    public function testGradeCreate()
    {
        $grade = factory(Grade::class)->make();

        $model = $this->classRepository->createGrade($grade->toArray());

        $this->assertArrayValuesEquals($model, $grade);
    }

    public function testGradeUpdate()
    {
        $grade = factory(Grade::class)->create();

        $gradeNew = factory(Grade::class)->make();

        $model = $this->classRepository->updateGrade($gradeNew->toArray(), $grade->id);

        $this->assertArrayValuesEquals($model, $gradeNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->classRepository = $this->app->make(ClassRepository::class);
    }
}
