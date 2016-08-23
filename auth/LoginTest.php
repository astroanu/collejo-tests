<?php

namespace App\Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Models\Media;
use Collejo\App\Models\User;
use Collejo\App\Models\Student;
use Collejo\App\Models\StudentCategory;

class LoginTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testLoginRoute()
    {
        $this->assertResponseOk($this->call('GET', '/auth/login'));
    }

    public function testLogin()
    {
    	factory(StudentCategory::class, 5)->create();
    	factory(Media::class)->create();

    	$subject = factory(User::class)->create();
		$subject->student()->save(factory(Student::class)->make());

    	$this->assertResponseOk($this->call('POST', '/auth/login', [
    			'email' => $subject->email,
    			'password' => 123
    		]));
    }

    public function setup()
    {
        parent::setup();
    }    
}
