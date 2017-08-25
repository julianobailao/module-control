<?php

namespace Tests;

use JWTAuth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];

        $user = factory(\Modules\ModuleControl\Entities\User::class)->create();
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        $headers['Authorization'] = 'Bearer '.$token;

        return $headers;
    }

    public function json($method, $uri, array $data = [], array $headers = [])
    {
        $headers = array_merge($headers, $this->headers());

        return parent::json($method, $uri, $data, $headers);
    }
}
