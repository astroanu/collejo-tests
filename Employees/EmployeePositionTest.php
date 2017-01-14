<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\EmployeeRepository;
use Collejo\App\Models\EmployeeCategory;
use Collejo\App\Models\EmployeePosition;
use Tests\TestCase;

class EmployeePositionTest extends TestCase
{
    use DatabaseMigrations;

    private $employeeRepository;

    public function testEmployeePositionCreate()
    {
        $category = factory(EmployeeCategory::class)->create();
        $employeePosition = factory(EmployeePosition::class)->make(['employee_category_id' => $category->id]);

        $model = $this->employeeRepository->createEmployeePosition($employeePosition->toArray());

        $this->assertArrayValuesEquals($model, $employeePosition);
    }

    public function testEmployeePositionUpdate()
    {
        $employeePosition = factory(EmployeePosition::class)->create();

        $category = factory(EmployeeCategory::class)->create();
        $employeePositionNew = factory(EmployeePosition::class)->make(['employee_category_id' => $category->id]);

        $model = $this->employeeRepository->updateEmployeePosition($employeePositionNew->toArray(), $employeePosition->id);

        $this->assertArrayValuesEquals($model, $employeePositionNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->employeeRepository = $this->app->make(EmployeeRepository::class);
    }
}
