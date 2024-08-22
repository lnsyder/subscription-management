<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test show method returns user data.
     *
     * @return void
     */
    public function test_show_method_returns_user_data(): void
    {
        $user = User::factory()->create();

        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('getUserWithDetails')
            ->once()
            ->with($user->id)
            ->andReturn($user);

        $controller = new UserController($serviceMock);

        $response = $controller->show($user->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $responseData = $response->getData(true);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertEquals($user->id, $responseData['user']['id']);
        $this->assertEquals($user->name, $responseData['user']['name']);
    }

    /**
     * Test show method handles exception.
     *
     * @return void
     */
    public function test_show_method_handles_exception(): void
    {
        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('getUserWithDetails')
            ->once()
            ->with(999)
            ->andThrow(new \Exception('User not found'));

        $controller = new UserController($serviceMock);

        $response = $controller->show(999);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());

        $responseData = $response->getData(true);
        $this->assertArrayHasKey('error', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Failed to retrieve user', $responseData['error']);
        $this->assertEquals('User not found', $responseData['message']);
    }
}
