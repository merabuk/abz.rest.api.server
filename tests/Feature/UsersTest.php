<?php

namespace Tests\Feature;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use WithFaker;
    /**
     * Successfully getting a list of Users with pagination
     *
     * @return void
     */
    public function test_success_get_users_index_paginate()
    {
        $page = 1;
        $count = 5;

        $response = $this->getJson(route('users.index', ['page' => $page, 'count' => $count]));

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'page',
                    'total_pages',
                    'total_users',
                    'count',
                    'links.next_url',
                    'links.prev_url',
                    'users'])
                    ->where('success', true);
            });
    }

    /**
     * Parameter 'count' greater than maximum
     *
     * @return void
     */
    public function test_count_greater_then_max_users_index()
    {
        $count = 101;

        $response = $this->getJson(route('users.index', ['count' => $count]));

        $response
            ->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'message', 'fails.count'])
                    ->where('success', false)
                    ->where('message', 'Validation failed');
            });
    }

    /**
     * Parameter 'count' less than minimum
     *
     * @return void
     */
    public function test_count_less_then_min_users_index_paginate()
    {
        $count = 0;

        $response = $this->getJson(route('users.index', ['count' => $count]));

        $response
            ->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'message', 'fails.count'])
                    ->where('success', false)
                    ->where('message', 'Validation failed');
            });
    }

    /**
     * Parameter 'page' is greater than the number of paginator pages
     *
     * @return void
     */
    public function test_page_not_found_users_index_paginate()
    {
        $countRecords = User::all()->count();
        $count = 5;
        $page = intval(ceil($countRecords/$count)) + 1;

        $response = $this->getJson(route('users.index', ['page' => $page,
                                                                'count' => $count]));

        $response
            ->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'message'])
                    ->where('success', false)
                    ->where('message', 'Page not found');
            });
    }

    /**
     * Successfully getting a list of Users with offset
     *
     * @return void
     */
    public function test_success_get_users_index_offset()
    {
        $page = 1;
        $offset = 10;
        $count = 5;

        $response = $this->getJson(route('users.index', ['page' => $page,
                                                                'offset' => $offset,
                                                                'count' => $count]));

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'users'])
                    ->where('success', true);
            });
    }

    /**
     * Parameters 'page', 'count' and 'offset'  must not be strings
     *
     * @return void
     */
    public function test_string_param_users_index()
    {
        $page = 'string';
        $offset = 'string';
        $count = 'string';

        $response = $this->getJson(route('users.index', ['page' => $page,
                                                                'offset' => $offset,
                                                                'count' => $count]));

        $response
            ->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'message',
                    'fails.page',
                    'fails.count',
                    'fails.offset'
                    ])
                    ->where('success', false)
                    ->where('message', 'Validation failed');
            });
    }

    /**
     * Successfully getting a User by id
     *
     * @return void
     */
    public function test_success_get_users_show()
    {
        $id = User::first()->id;

        $response = $this->getJson(route('users.show', ['id' => $id]));

        $response
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'user.id',
                    'user.name',
                    'user.email',
                    'user.phone',
                    'user.position',
                    'user.position_id',
                    'user.photo'
                ])
                    ->where('success', true);
            });
    }

    /**
     * User not found by id
     *
     * @return void
     */
    public function test_not_found_users_show()
    {
        $id = 0;

        $response = $this->getJson(route('users.show', ['id' => $id]));

        $response
            ->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'message',
                    'fails.user_id.0'
                ])
                    ->where('success', false)
                    ->where('message', 'The user with the requested identifier does not exist')
                    ->where('fails.user_id.0', 'User not found');
            });
    }

    /**
     * Id must not be a string
     *
     * @return void
     */
    public function test_id_not_an_integer_users_show()
    {
        $id = 'string';

        $response = $this->getJson(route('users.show', ['id' => $id]));

        $response
            ->assertStatus(400)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll([
                    'success',
                    'message',
                    'fails.user_id.0'
                ])
                    ->where('success', false)
                    ->where('message', 'Validation failed')
                    ->where('fails.user_id.0', 'The user_id must be an integer.');
            });
    }

//    /**
//     * Successfully creating a User
//     *
//     * @return void
//     */
//    public function test_success_create_users_store()
//    {
//        $user = User::factory()->make([
//            'name' => $this->faker->name(),
//            'email' => $this->faker->unique()->safeEmail(),
//            'phone' => $this->faker->numerify('+380#########'),
//            'position_id' => Position::get()->random()->id,
//            'photo' => UploadedFile::fake()
//                ->image('avatar.jpg', 100, 100)
//                ->size(100),
//        ]);
////        $name = $this->faker->name();
////        $email = $this->faker->unique()->safeEmail();
////        $phone = $this->faker->numerify('+380#########');
////        $positionId = Position::get()->random()->id;
////        $photo = UploadedFile::fake()
////                ->image('avatar.jpg', 100, 100)
////                ->size(100);
////        $user = "{
////            'name': '$name',
////            'email':  '$email',
////            'phone': '$phone',
////            'position_id': '$positionId',
////            'photo': '$photo'
////        }";
//
//        dd($user->toArray());
//        $token = $this->getJson(route('token'))->decodeResponseJson();
//
//        $header = [
//            'Authorization' => 'Bearer '.$token['token'],
//            'Content-Type' => 'multipart/form-data',
//        ];
//
//        $this->post();
//        $response = $this->postJson(route('users.store'), $user->toArray(), $header);
//
//        dd($response->decodeResponseJson());
//        $response
//            ->assertStatus(200)
//            ->assertJson(function (AssertableJson $json) {
//                $json->hasAll([
//                    'success',
//                    'user_id',
//                    'message'
//                ])
//                    ->where('success', true)
//                    ->where('message', 'New user successfully registered');
//            });
//    }
}
