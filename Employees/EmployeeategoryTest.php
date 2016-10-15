<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\EmployeeRepository;
use Collejo\App\Models\EmployeeCategory;
use Tests\TestCase;

class EmployeeategoryTest extends TestCase
{
    use DatabaseMigrations;

    private $employeeRepository;

    public function testEmployeeCategoryCreate()
    {
        $employeeCategory = factory(EmployeeCategory::class)->make();

        $model = $this->employeeRepository->createEmployeeCategory($employeeCategory->toArray());

        $this->assertArrayValuesEquals($model, $employeeCategory);
    }

    public function testEmployeeCategoryUpdate()
    {
        $employeeCategory = factory(EmployeeCategory::class)->create();

        $employeeCategoryNew = factory(EmployeeCategory::class)->make();

        $model = $this->employeeRepository->updateEmployeeCategory($employeeCategoryNew->toArray(), $employeeCategory->id);

        $this->assertArrayValuesEquals($model, $employeeCategoryNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->employeeRepository = $this->app->make(EmployeeRepository::class);
    }
}
