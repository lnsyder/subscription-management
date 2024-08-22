<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Subscription;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\TransactionController;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function test_store_method_creates_transaction(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create();
        $transactionData = [
            'subscription_id' => $subscription->id,
            'price' => 100.00
        ];

        $requestMock = Mockery::mock(TransactionRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($transactionData);

        $serviceMock = Mockery::mock(TransactionService::class);
        $serviceMock->shouldReceive('create')->once()->with($user, $transactionData)
            ->andReturn(new Transaction(array_merge($transactionData, ['user_id' => $user->id])));

        $controller = new TransactionController($serviceMock);

        $response = $controller->store($requestMock, $user);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_store_method_handles_exception(): void
    {
        $user = User::factory()->create();
        $transactionData = [
            'subscription_id' => 1,
            'price' => 100.00
        ];

        $requestMock = Mockery::mock(TransactionRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($transactionData);

        $serviceMock = Mockery::mock(TransactionService::class);
        $serviceMock->shouldReceive('create')->once()->with($user, $transactionData)
            ->andThrow(new Exception('Payment processing error'));

        $controller = new TransactionController($serviceMock);

        $response = $controller->store($requestMock, $user);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Payment processing error', $response->getData()->message);
    }
}
