<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PositionsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * The successful receipt of a collection of Positions
     *
     * @return void
     */
    public function test_success_get_positions()
    {
        $response = $this->getJson(route('positions.index'));

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'positions.0.id',
                    'positions.0.name'
                ])
                    ->etc()
                    ->where('success', true);
            });
    }

    /**
     * For an exception in case of an empty collection of Positions
     *
     * @return void
     */
    public function test_not_found_positions()
    {
        DB::table('positions')->delete();

        $response = $this->getJson(route('positions.index'));

        $this->refreshDatabase();

        $response
            ->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'message'])
                    ->where('success', false)
                    ->where('message', 'Positions not found');
            });
    }
}
