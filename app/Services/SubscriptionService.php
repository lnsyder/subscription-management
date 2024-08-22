<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;

class SubscriptionService
{
    /**
     * @param User $user
     * @param array $data
     * @return Subscription
     */
    public function create(User $user, array $data): Subscription
    {
        return $user->subscriptions()->create($data);
    }

    /**
     * @param Subscription $subscription
     * @param array $data
     * @return Subscription
     */
    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);
        return $subscription;
    }

    /**
     * @param Subscription $subscription
     * @return void
     */
    public function delete(Subscription $subscription): void
    {
        $subscription->delete();
    }
}
