<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\SubjectRepository;
use Collejo\App\Models\Subject;
use Tests\TestCase;

class SubjectTest extends TestCase
{
    use DatabaseMigrations;

    private $subjectRepository;

    public function testSubjectCreate()
    {
        $subject = factory(Subject::class)->create();

        $model = $this->subjectRepository->createSubject($subject->toArray());

        $this->assertArrayValuesEquals($model, $subject);
    }

    public function testSubjectUpdate()
    {
        $subject = factory(Subject::class)->create();

        $subjectNew = factory(Subject::class)->make();

        $model = $this->subjectRepository->updateSubject($subjectNew->toArray(), $subject->id);

        $this->assertArrayValuesEquals($model, $subjectNew);
    }    

    public function setup()
    {
        parent::setup();
        
        $this->subjectRepository = $this->app->make(SubjectRepository::class);
    }
}
