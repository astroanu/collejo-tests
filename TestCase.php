<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Collejo\Core\Contracts\Console\Kernel;
use Collejo\Core\Contracts\Http\Kernel as Http;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;

abstract class TestCase extends IlluminateTestCase
{
    use DatabaseMigrations;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->baseUrl = env('APP_URL');
        
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $kernel = $this->app->make(Http::class);

        $this->currentUri = $this->prepareUrlForRequest($uri);

        $this->resetPageContext();

        $request = Request::create(
            $this->currentUri, $method, $parameters,
            $cookies, $files, array_replace($this->serverVariables, $server), $content
        );

        $response = $kernel->handle($request);

        $kernel->terminate($request, $response);

        return $this->response = $response;
    }

    public function artisan($command, $parameters = [])
    {
        return $this->code = $this->app[Kernel::class]->call($command, $parameters);
    } 

    public function assertArrayValuesEquals($a, $b)
    {
        $a = !is_array($a) ? $a->toArray() : $a;
        $b = !is_array($b) ? $b->toArray() : $b;

        if (isset($a['id'])) { unset($a['id']); }        

        if (isset($b['id'])) { unset($b['id']); }

        foreach($b as $k => $v) {
            if (isset($a[$k])) {
                if ($v != $a[$k]) {
                    return $this->assertTrue(false);
                }
            }
        } 
        
        return $this->assertTrue(true);       
    }

    public function assertArrayEquals($a, $b) {
        $a = !is_array($a) ? $a->toArray() : $a;
        $b = !is_array($b) ? $b->toArray() : $b;

        if (isset($a['id'])) { unset($a['id']); }        

        if (isset($b['id'])) { unset($b['id']); }

        if (count(array_diff_assoc($a, $b))) {
            return $this->assertTrue(false);
        }

        foreach($a as $k => $v) {
            if ($v !== $b[$k]) {
                return $this->assertTrue(false);
            }
        }

        return $this->assertTrue(true);
    }          
}
