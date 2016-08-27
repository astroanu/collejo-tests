<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\Core\Contracts\Repository\ClassRepository;
use Collejo\App\Models\Batch;

class BatchTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    private $classRepository;

    public function testBatchCreate()
    {
        $batch = factory(Batch::class)->create();

        $model = $this->classRepository->createBatch($batch->toArray());

        $this->assertArrayValuesEquals($model, $batch);
    }

    public function testBatchUpdate()
    {
        $batch = factory(Batch::class)->create();
        $batchNew = factory(Batch::class)->make();

        $model = $this->classRepository->updateBatch($batchNew->toArray(), $batch->id);

        $this->assertArrayValuesEquals($model, $batchNew);
    }    

    public function setup()
    {
        parent::setup();
        
        $this->classRepository = $this->app->make(ClassRepository::class);
    }
}
