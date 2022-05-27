<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_token_return_data_in_valid_format()
    {
        $uri = route('token');
        $this->json('get', $uri)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'token'
            ]);
    }
}
