<?php

namespace Tests\Classes;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Collejo\App\Contracts\Repository\ClassRepository;
use Collejo\App\Models\Term;
use Collejo\App\Models\Batch;
use Tests\TestCase;

class TermTest extends TestCase
{
    use DatabaseMigrations;

    private $classRepository;

    public function testTermCreate()
    {
        $batch = factory(Batch::class)->create();
        $term = factory(Term::class)->make();

        $model = $this->classRepository->createTerm($term->toArray(), $batch->id);

        $this->assertArrayValuesEquals($model, $term);
    }

    public function testTermUpdate()
    {
        $batch = factory(Batch::class)->create();

        $term = factory(Term::class)->create(['batch_id' => $batch->id]);
        $termNew = factory(Term::class)->make();

        $model = $this->classRepository->updateTerm($termNew->toArray(), $term->id, $batch->id);

        $this->assertArrayValuesEquals($model, $termNew);
    }    

    public function setup()
    {
        parent::setup();
        
        $this->classRepository = $this->app->make(ClassRepository::class);
    }
}
