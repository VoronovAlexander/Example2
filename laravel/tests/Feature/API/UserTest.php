<?php

namespace Tests\Feature\API;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Тестирование листинга пользователей
     * GET /api/v1/users
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory('App\User')
            ->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/v1/users');

        $response->assertJson(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                        ],
                    ],
                    'meta' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total',
                    ],
                ],
            ]);
    }

    /**
     * Тестирование создание пользователей
     * POST /api/v1/users
     *
     * @return void
     */
    public function testStore()
    {
        $user = factory('App\User')
            ->create();

        $newUserData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password(8, 8),
        ];

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/v1/users', $newUserData);

        $response->assertJson(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);

        $jsonContent = $response->getContent();
        $newUser = json_decode($jsonContent);
        $newUser = User::find($newUser->data->id);

        $this->assertTrue(Hash::check($newUserData['password'], $newUser->password));
    }

    /**
     * Тестирование просмотра пользователя
     * GET /api/v1/users/{id}
     *
     * @return void
     */
    public function testShow()
    {
        $user = factory('App\User')
            ->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', "/api/v1/users/{$user->id}");

        $response->assertJson([
            'status' => true,
            'data' => [
                'id' => (int) $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Тестирование изменения пользователя
     * PUT /api/v1/users/{id}
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory('App\User')
            ->create();

        $newUserData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password(8, 8),
        ];

        $response = $this->actingAs($user, 'api')
            ->json('PUT', "/api/v1/users/{$user->id}", $newUserData);

        $response->assertJson([
            'status' => true,
            'data' => [
                'id' => (int) $user->id,
                'name' => $newUserData['name'],
                'email' => $newUserData['email'],
            ],
        ]);

        $user->refresh();

        $this->assertTrue(Hash::check($newUserData['password'], $user->password));
    }

    /**
     * Тестирование удаления пользователя
     * DELETE /api/v1/users/{id}
     *
     * @return void
     */
    public function testDelete()
    {
        $user = factory('App\User')
            ->create();

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', "/api/v1/users/{$user->id}");

        $response->assertJson(['status' => true]);
    }
}
