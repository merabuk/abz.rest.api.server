<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PositionControllerTestDB extends TestCase
{
    use DatabaseMigrations;

    protected $seed = true;

    public function test_index_return_empty_collection()
    {
        DB::table('positions')->delete();
        $uri = route('positions.index');
        $this->json('get', $uri)
            ->assertStatus(422)
            ->assertExactJson([
                'success' => false,
                'message' => 'Positions not found'
            ]);
    }
}
