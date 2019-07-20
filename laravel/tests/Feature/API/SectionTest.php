<?php

namespace Tests\Feature\API;

use App\Section;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SectionTest extends TestCase
{

    /**
     * Тестирование метода получения листинга отделов
     * GET /api/v1/sections
     *
     * @return void
     */
    public function testIndex()
    {
        Artisan::call('db:seed');

        $user = factory('App\User')
            ->create();

        $sections = Section::orderByDesc('id')
            ->limit(10);

        $sections->each(function ($section) use ($user) {
            $section->users()
                ->sync([$user->id]);
        });

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/v1/sections');

        $response
            ->assertJson(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'logo',
                            'created_at',
                            'users' => [
                                '*' => [
                                    'id',
                                    'name',
                                    'email',
                                ],
                            ],
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
     * Тестирование метода создания секции
     * POST /api/v1/sections
     */
    public function testStore()
    {
        $user = factory('App\User')
            ->create();

        $data = factory('App\Section')
            ->make()
            ->toArray();

        $data = array_merge($data, ['user_ids' => [$user->id]]);

        $data['logo'] = UploadedFile::fake()
            ->image('logo.jpg');

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/v1/sections', $data);

        $response
            ->assertJson(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'logo',
                    'created_at',
                ],
            ]);
    }

    /**
     * Тестирование просмотра
     * GET /api/v1/users/{id}
     *
     * @return void
     */
    public function testShow()
    {
        $user = factory('App\User')
            ->create();

        $section = factory('App\Section')
            ->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', "/api/v1/sections/{$section->id}");

        $response->assertJson(['status' => true])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'logo',
                ],
            ]);
    }

    /**
     * Тестирование изменения отдела
     * PUT /api/v1/users/{id}
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = factory('App\User')
            ->create();

        $section = factory('App\Section')
            ->create();

        $newSectionData = [
            'name' => $this->faker->company,
            'description' => $this->faker->realText(500),
            'logo' => null,
            'user_ids' => [$user->id],
        ];

        $response = $this->actingAs($user, 'api')
            ->json('PUT', "/api/v1/sections/{$section->id}", $newSectionData);

        $response->assertJson([
            'status' => true,
            'data' => [
                'id' => (int) $section->id,
                'name' => $newSectionData['name'],
                'description' => $newSectionData['description'],
            ],
        ]);
    }

    /**
     * Тестирование удаления отдела
     * DELETE /api/v1/sections/{id}
     *
     * @return void
     */
    public function testDelete()
    {
        $user = factory('App\User')
            ->create();

        $section = factory('App\Section')
            ->create();

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', "/api/v1/sections/{$user->id}");

        $response->assertJson(['status' => true]);
    }
}
