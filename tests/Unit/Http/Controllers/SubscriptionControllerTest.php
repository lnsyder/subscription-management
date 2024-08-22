<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Http\Requests\SubscriptionRequest;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_store_method_creates_subscription(): void
    {
        $user = User::factory()->create();
        $subscriptionData = [
            'user_id' => $user->id,
            'renewal_at' => now()->addMonth(),
        ];

        $requestMock = Mockery::mock(SubscriptionRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($subscriptionData);

        $serviceMock = Mockery::mock(SubscriptionService::class);
        $serviceMock->shouldReceive('create')->once()->andReturn(new Subscription($subscriptionData));

        $controller = new SubscriptionController($serviceMock);

        $response = $controller->store($requestMock, $user);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function test_update_method_updates_subscription(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'renewal_at' => now()->addMonth(),
        ]);

        $updatedData = [
            'user_id' => $user->id,
            'renewal_at' => now()->addMonths(2),
        ];

        $requestMock = Mockery::mock(SubscriptionRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($updatedData);

        $serviceMock = Mockery::mock(SubscriptionService::class);
        $serviceMock->shouldReceive('update')->once()->andReturn(new Subscription($updatedData));

        $controller = new SubscriptionController($serviceMock);

        $response = $controller->update($requestMock, $user, $subscription);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function test_destroy_method_deletes_subscription(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $serviceMock = Mockery::mock(SubscriptionService::class);
        $serviceMock->shouldReceive('delete')->once()->andReturn(true);

        $controller = new SubscriptionController($serviceMock);

        $response = $controller->destroy($user, $subscription);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
