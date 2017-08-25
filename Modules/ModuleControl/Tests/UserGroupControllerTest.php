<?php

namespace Modules\ModuleControl\Tests;

use Tests\TestCase;
use Tests\Traits\DatabaseMigrations;

class UserGroupControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class, 50)->create();
        $response = $this->json('GET', '/api/user-groups');

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class)->create();
        $response = $this->json('GET', sprintf('/api/user-groups/%s', $factory->id));

        $response
            ->assertStatus(200)
            ->assertJson($factory->toArray());
    }

    public function testStoreValidation()
    {
        $response = $this->json('POST', '/api/user-groups', []);

        $response->assertStatus(422);
    }

    public function testStore()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class)->make();
        $response = $this->json('POST', '/api/user-groups', $factory->toArray());

        $response
            ->assertStatus(201)
            ->assertJson($factory->toArray());
    }

    public function testUpdateUniqueValidation()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class)->create();
        $factory2 = factory(\Modules\ModuleControl\Entities\UserGroup::class)->create();
        $response = $this->json('PUT', sprintf('/api/user-groups/%s', $factory->id), $factory2->toArray());

        $response->assertStatus(422);
    }


    public function testUpdate()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class)->create();
        $updateData = factory(\Modules\ModuleControl\Entities\UserGroup::class)->make();
        $response = $this->json('PUT', sprintf('/api/user-groups/%s', $factory->id), $updateData->toArray());

        $response
            ->assertStatus(200)
            ->assertJsonFragment($updateData->toArray());
    }

    public function testDestroy()
    {
        $factory = factory(\Modules\ModuleControl\Entities\UserGroup::class)->create();
        $response = $this->json('DELETE', sprintf('/api/user-groups/%s', $factory->id));

        $response->assertStatus(204);
        $this->assertEquals(null, \Modules\ModuleControl\Entities\UserGroup::find($factory->id));
    }
}
