<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

//        $response->dumpHeaders();
//        $response->dumpSession();
//        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * Отвлеченный пример функционального теста.
     *
     * @return void
     */
    public function test_api_users_list_request()
    {
        $response = $this->getJson('/api/users/list');
        $response->assertStatus(200);
        $response->dump();
    }
}
