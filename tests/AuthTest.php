<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    public function test_register_endpoint()
    {
        $this->json('POST', '/register',
            [
                'username' => 'John',
                'password' => '1234'
            ])
            ->seeJson([
                'result' => 7,
            ])
            ->seeStatusCode(201);
    }

    public function test_login_endpoint()
    {
        $this->json('POST', '/login',
            [
                'username' => 'John',
                'password' => '1234'
            ])
            ->seeStatusCode(200);
    }
}
