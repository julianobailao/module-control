<?php

namespace Modules\ModuleControl\Tests;

use Tests\TestCase;
use Tests\Traits\DatabaseMigrations;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class, 50)->create();
        $response = $this->json('GET', '/api/users');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $response = $this->json('GET', sprintf('/api/users/%s', $factory->id));

        $response
            ->assertStatus(200)
            ->assertJson($factory->toArray());
    }

    public function testStoreValidation()
    {
        $response = $this->json('POST', '/api/users', []);

        $response->assertStatus(422);
    }

    public function testStore()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->make();
        $data = $factory->toArray();
        $data['password'] = '12345678';
        $response = $this->json('POST', '/api/users', $data);

        $response
            ->assertStatus(201)
            ->assertJson($factory->toArray());
    }

    public function testUpdateUniqueValidation()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $factory2 = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $response = $this->json('PUT', sprintf('/api/users/%s', $factory->id), $factory2->toArray());

        $response->assertStatus(422);
    }


    public function testUpdate()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $updateData = factory(\Modules\ModuleControl\Entities\User::class)->make();
        $response = $this->json('PUT', sprintf('/api/users/%s', $factory->id), $updateData->toArray());

        $response
            ->assertStatus(200)
            ->assertJsonFragment($updateData->toArray());
    }

    public function testDestroy()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $response = $this->json('DELETE', sprintf('/api/users/%s', $factory->id));

        $response->assertStatus(204);
        $this->assertEquals(null, \Modules\ModuleControl\Entities\User::find($factory->id));
    }
}
