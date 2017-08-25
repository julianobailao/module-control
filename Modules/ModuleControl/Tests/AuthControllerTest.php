<?php

namespace Modules\ModuleControl\Tests;

use Tests\TestCase;
use Tests\Traits\DatabaseMigrations;

class AuthControllerTest extends TestCase
{
    protected $password = 12345678;

    use DatabaseMigrations;

    public function testLoginValidation()
    {
        $response = $this->json('POST', '/api/auth', []);

        $response->assertStatus(422);
    }

    public function testLoginWithInvalidCredentials()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->make(['password' => $this->password]);
        $data = $factory->toArray();
        $data['password'] = $this->password;
        $response = $this->json('POST', '/api/auth', $data);

        $response->assertStatus(401);
    }

    public function testLogin()
    {
        $factory = factory(\Modules\ModuleControl\Entities\User::class)->create(['password' => bcrypt($this->password)]);
        $data = $factory->toArray();
        $data['password'] = $this->password;
        $response = $this->json('POST', '/api/auth', $data);

        $response->assertStatus(200);
    }
}
