<?php

namespace Tests;

use Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    use WithoutMiddleware;

    public function test_sum_endpoint()
    {
        $this->json('POST', '/sum',
            [
                'n1' => '3',
                'n2' => '4'
            ])
            ->seeJson([
                'result' => 7,
            ]);
    }

    public function test_minus_endpoint()
    {
        $this->json('POST', '/minus',
            [
                'n1' => '4',
                'n2' => '1'
            ])
            ->seeJson([
                'result' => 3,
            ]);
    }
}
