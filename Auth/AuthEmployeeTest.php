<?php

namespace Tests\Auth;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\EmployeeRepository;
use Collejo\App\Models\User;
use Collejo\App\Models\Employee;
use Collejo\App\Models\EmployeeCategory;
use Collejo\App\Models\EmployeeDepartment;
use Collejo\App\Models\EmployeeGrade;
use Collejo\App\Models\EmployeePosition;
use Tests\TestCase;
use Auth;

class AuthEmployeeTest extends TestCase
{
    use DatabaseMigrations;

    private $employeeRepository;

    public function testEmployeeCreate()
    {
        $user = factory(User::class)->make();
        $employee = factory(Employee::class)->make();

        $model = $this->employeeRepository->createEmployee(array_merge($user->toArray(), $employee->toArray()));

        $this->assertArrayValuesEquals($model, $employee);
    }

    public function testEmployeeUpdate()
    {
        $employee = factory(User::class)->create()->employee()->save(factory(Employee::class)->make());

        $employeeNew = factory(Employee::class)->make();
        $userNew = factory(Employee::class)->make();

        $data = array_merge($userNew->toArray(), $employeeNew->toArray());

        $model = $this->employeeRepository->updateEmployee($data, $employee->id);

        $this->assertArrayValuesEquals($model, $data);
    }

    public function testEmployeeLogin()
    {
        $user = factory(User::class)->create();
        $employee = factory(Employee::class)->create(['user_id' => $user->id]);

        $result = Auth::attempt(['email' => $employee->user->email, 'password' => '123']);

        $this->assertTrue($result);
    }

    public function setup()
    {
        parent::setup();
        
        $this->employeeRepository = $this->app->make(EmployeeRepository::class);

        factory(EmployeeCategory::class, 3)->create();
        factory(EmployeeDepartment::class, 3)->create();
        factory(EmployeeGrade::class, 3)->create();
        factory(EmployeePosition::class, 3)->create();
    }
}
