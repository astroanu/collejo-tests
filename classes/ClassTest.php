<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\ClassRepository;
use Collejo\App\Models\Clasis;
use Collejo\App\Models\Grade;
use Tests\TestCase;

class ClassTest extends TestCase
{
    use DatabaseMigrations;

    private $classRepository;

    public function testClassCreate()
    {
        $class = factory(Clasis::class)->make();
        $grade = factory(Grade::class)->create();

        $model = $this->classRepository->createClass($class->toArray(), $grade->id);

        $this->assertArrayValuesEquals($model, $class);
    }

    public function testClassUpdate()
    {
        $grade = factory(Grade::class)->create();
        $class = factory(Clasis::class)->create(['grade_id' => $grade->id]);

        $classNew = factory(Clasis::class)->make();

        $model = $this->classRepository->updateClass($classNew->toArray(), $class->id, $class->grade->id);

        $this->assertArrayValuesEquals($model, $classNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->classRepository = $this->app->make(ClassRepository::class);
    }
}
