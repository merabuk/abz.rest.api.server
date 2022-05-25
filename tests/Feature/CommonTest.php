<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CommonTest extends TestCase
{
    /**
     * Successful receipt of JWT token
     *
     * @return void
     */
    public function test_token_route()
    {
        $response = $this->getJson(route('token'));

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'token'
                ])
                    ->where('success', true);
            });
    }
}
