<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Http\Requests\SubscriptionRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    /**
     * @var SubscriptionService
     */
    private SubscriptionService $subscriptionService;

    /**
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * @param SubscriptionRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function store(SubscriptionRequest $request, User $user): JsonResponse
    {
        try {
            $subscription = $this->subscriptionService->create($user, $request->validated());
            return response()->json(['subscription' => $subscription], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Subscription creation failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @param SubscriptionRequest $request
     * @param User $user
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function update(SubscriptionRequest $request, User $user, Subscription $subscription): JsonResponse
    {
        try {
            $updatedSubscription = $this->subscriptionService->update($subscription, $request->validated());
            return response()->json(['subscription' => $updatedSubscription]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Subscription update failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @param User $user
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function destroy(User $user, Subscription $subscription): JsonResponse
    {
        try {
            $this->subscriptionService->delete($subscription);
            return response()->json(['message' => 'Subscription successfully deleted']);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Subscription deletion failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
