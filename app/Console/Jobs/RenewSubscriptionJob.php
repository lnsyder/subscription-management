<?php

namespace App\Console\Jobs;

use App\Models\Subscription;
use App\Services\TransactionService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RenewSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Subscription
     */
    protected Subscription $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $transactionService = new TransactionService();
        $transactionService->create($this->subscription->user, ['subscription_id' => $this->subscription->id]);
    }
}
