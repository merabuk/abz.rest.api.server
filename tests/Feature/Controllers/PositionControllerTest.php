<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class PositionControllerTest extends TestCase
{
    public function test_index_return_data_in_valid_format()
    {
        $uri = route('positions.index');
        $this->json('get', $uri)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'positions' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]);
    }

    public function test_index_not_found()
    {
        $uri = route('positions.index');
        $this->json('get', $uri.'s')
            ->assertStatus(404)
            ->assertExactJson([
                'success' => false,
                'message' => 'Page not found'
            ]);
    }
}
