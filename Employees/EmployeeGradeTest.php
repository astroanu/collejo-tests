<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\EmployeeRepository;
use Collejo\App\Models\EmployeeGrade;
use Tests\TestCase;

class EmployeeGradeTest extends TestCase
{
    use DatabaseMigrations;

    private $employeeRepository;

    public function testEmployeeGradeCreate()
    {
        $employeeGrade = factory(EmployeeGrade::class)->make();

        $model = $this->employeeRepository->createEmployeeGrade($employeeGrade->toArray());

        $this->assertArrayValuesEquals($model, $employeeGrade);
    }

    public function testEmployeeGradeUpdate()
    {
        $employeeGrade = factory(EmployeeGrade::class)->create();

        $employeeGradeNew = factory(EmployeeGrade::class)->make();

        $model = $this->employeeRepository->updateEmployeeGrade($employeeGradeNew->toArray(), $employeeGrade->id);

        $this->assertArrayValuesEquals($model, $employeeGradeNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->employeeRepository = $this->app->make(EmployeeRepository::class);
    }
}
