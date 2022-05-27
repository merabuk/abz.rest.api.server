<?php

namespace Tests\Feature\Controllers;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use WithFaker;

    public function test_index_return_data_in_valid_format_whit_paginate()
    {
        $page = 1;
        $count = 5;
        $uri = route('users.index', ['page' => $page, 'count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'page',
                'total_pages',
                'total_users',
                'count',
                'links' => [
                    'next_url',
                    'prev_url'
                ],
                'users' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'position',
                        'position_id',
                        'registration_timestamp',
                        'photo'
                    ]
                ]
            ]);
    }

    public function test_parameter_count_greater_then_max_value()
    {
        $count = 101;
        $uri = route('users.index', ['count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed'
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'fails' => [
                    'count'
                ]
            ]);
    }

    public function test_parameter_count_less_then_min_value()
    {
        $count = 0;
        $uri = route('users.index', ['count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed'
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'fails' => [
                    'count'
                ]
            ]);
    }

    public function test_parameter_page_greater_then_last_page_of_paginator()
    {
        $countRecords = User::all()->count();
        $count = 5;
        $page = intval(ceil($countRecords/$count)) + 1;
        $uri = route('users.index', ['page' => $page, 'count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(404)
            ->assertExactJson([
                'success' => false,
                'message' => 'Page not found'
            ]);
    }

    public function test_index_return_data_in_valid_format_whit_offset()
    {
        $page = 1;
        $offset = 10;
        $count = 5;
        $uri = route('users.index', ['page' => $page, 'offset' => $offset, 'count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'users' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'position',
                        'position_id',
                        'registration_timestamp',
                        'photo'
                    ]
                ]
            ]);
    }

    public function test_fail_when_parameters_is_string()
    {
        $page = 'string';
        $offset = 'string';
        $count = 'string';
        $uri = route('users.index', ['page' => $page, 'offset' => $offset, 'count' => $count]);
        $this->json('get', $uri)
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed'
                ])
            ->assertJsonStructure([
                'success',
                'message',
                'fails' => [
                    'page',
                    'count',
                    'offset'
                ]
            ]);
    }

    public function test_show_return_data_in_valid_format()
    {
        $id = User::first()->id;
        $uri = route('users.show', ['id' => $id]);
        $this->json('get', $uri)
            ->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'position',
                    'position_id',
                    'photo'
                ]
            ]);
    }

    public function test_show_for_missing_user()
    {
        $id = 0;
        $uri = route('users.show', ['id' => $id]);
        $this->json('get', $uri)
            ->assertStatus(404)
            ->assertExactJson([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
                'fails' => [
                    'user_id' => ['User not found']
                ]
            ]);
    }

    public function test_parameter_id_is_string()
    {
        $id = 'string';
        $uri = route('users.show', ['id' => $id]);
        $this->json('get', $uri)
            ->assertStatus(400)
            ->assertExactJson([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => [
                    'user_id' => ['The user_id must be an integer.']
                ]
            ]);
    }

    public function test_store_return_data_in_valid_format()
    {
        $user['name'] = $this->faker->name();
        $user['email'] = $this->faker->unique()->safeEmail();
        $user['phone'] = $this->faker->numerify('+380#########');
        $user['position_id'] = Position::get()->random()->id;
        $file['photo'] = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $request = new Request($user, $user, [], [], $file, []);
        $data = $request->only(['name', 'email', 'phone', 'position_id', 'photo']);
        $uri = route('users.store');
        $token = $this->getJson(route('token'))->decodeResponseJson();
        $headers = [
            'Authorization' => 'Bearer '.$token['token'],
        ];
        $this->json('post', $uri, $data, $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'New user successfully registered'
            ])
            ->assertJsonStructure([
                'success',
                'user_id',
                'message'
            ]);
    }

    public function test_store_validation_return_data_in_valid_format()
    {
        $user['name'] = 'A';
        $user['email'] = 'myemail';
        $user['phone'] = '123456789';
        $user['position_id'] = 5;
        $file['photo'] = UploadedFile::fake()->image('avatar.jpg', 10, 10)->size(100);
        $request = new Request($user, $user, [], [], $file, []);
        $data = $request->only(['name', 'email', 'phone', 'position_id', 'photo']);
        $uri = route('users.store');
        $token = $this->getJson(route('token'))->decodeResponseJson();
        $headers = [
            'Authorization' => 'Bearer '.$token['token'],
        ];
        $this->json('post', $uri, $data, $headers)
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed'
            ])
            ->assertJsonStructure([
                'success',
                'message',
                "fails" => [
                    'name',
                    'email',
                    'phone',
                    'position_id',
                    'photo'
                ]
            ]);
    }


    public function test_unique_email_or_phone()
    {
        $user1['name'] = 'John Snow';
        $user1['email'] = 'snow@winterfell.com';
        $user1['phone'] = '+380990011222';
        $user1['position_id'] = Position::get()->random()->id;
        $file1['photo'] = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $request1 = new Request($user1, $user1, [], [], $file1, []);
        $data1 = $request1->only(['name', 'email', 'phone', 'position_id', 'photo']);
        $token1 = $this->getJson(route('token'))->decodeResponseJson();
        $headers1 = [
            'Authorization' => 'Bearer '.$token1['token'],
        ];

        $user2['name'] = 'Aria Stark';
        $user2['email'] = 'snow@winterfell.com';
        $user2['phone'] = '+380990011222';
        $user2['position_id'] = Position::get()->random()->id;
        $file2['photo'] = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $request2 = new Request($user2, $user2, [], [], $file2, []);
        $data2 = $request2->only(['name', 'email', 'phone', 'position_id', 'photo']);
        $token2 = $this->getJson(route('token'))->decodeResponseJson();
        $headers2 = [
            'Authorization' => 'Bearer '.$token2['token'],
        ];

        $uri = route('users.store');
        $this->json('post', $uri, $data1, $headers1);
        $this->json('post', $uri, $data2, $headers2)
            ->assertStatus(409)
            ->assertExactJson([
                'success' => false,
                'message' => 'User with this phone or email already exist'
            ]);
    }

    public function test_token_expired()
    {
        $headers = [
            'Authorization' => 'Bearer ',
        ];
        $uri = route('users.store');
        $this->json('post', $uri, [], $headers)
            ->assertStatus(401)
            ->assertExactJson([
                'success' => false,
                'message' => 'The token expired.'
            ]);
    }
}
