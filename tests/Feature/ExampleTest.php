<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        if($response->getStatusCode() == 302) {
          $response->assertStatus(302);
        } else {
          $response->assertStatus(200);
        }
    }
}
