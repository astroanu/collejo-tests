<?php

namespace Tests\Students;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\EmployeeRepository;
use Collejo\App\Models\EmployeeDepartment;
use Tests\TestCase;

class EmployeeDepartmentTest extends TestCase
{
    use DatabaseMigrations;

    private $employeeRepository;

    public function testEmployeeDepartmentcreate()
    {
        $employeeDepartment = factory(EmployeeDepartment::class)->make();

        $model = $this->employeeRepository->createEmployeeDepartment($employeeDepartment->toArray());

        $this->assertArrayValuesEquals($model, $employeeDepartment);
    }

    public function testEmployeeDepartmentupdate()
    {
        $employeeDepartment = factory(EmployeeDepartment::class)->create();

        $employeeDepartmentNew = factory(EmployeeDepartment::class)->make();

        $model = $this->employeeRepository->updateEmployeeDepartment($employeeDepartmentNew->toArray(), $employeeDepartment->id);

        $this->assertArrayValuesEquals($model, $employeeDepartmentNew);
    }  

    public function setup()
    {
        parent::setup();
        
        $this->employeeRepository = $this->app->make(EmployeeRepository::class);
    }
}

