<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\ClassRepository;
use Collejo\App\Models\Batch;

class ClasisTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private $classRepository;

    public function testBatchCreate()
    {
        $expected = factory(Batch::class)->create();

        $result = $this->classRepository->createBatch($expected->toArray());

        $this->assertArrayValuesEquals($result, $expected);
    }

    public function testBatchUpdate()
    {
        $subject = factory(Batch::class)->create();
        $expected = factory(Batch::class)->make();

        $result = $this->classRepository->updateBatch($expected->toArray(), $subject->id);

        $this->assertArrayValuesEquals($result, $expected);
    }    

    public function setup()
    {
        parent::setup();

        $this->classRepository = $this->app->make(ClassRepository::class);
    }
}
