<?php

namespace App\Console\Commands;

use App\Console\Jobs\RenewSubscriptionJob;
use App\Models\Subscription;
use Exception;
use Illuminate\Console\Command;

class RenewSubscriptionsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'subscriptions:renew';

    /**
     * @var string
     */
    protected $description = 'Renew all due subscriptions';

    /**
     * @return void
     */
    public function handle(): void
    {

        $dueSubscriptions = Subscription::where('renewal_at', '<=', now())->get();

        foreach ($dueSubscriptions as $subscription) {
            try{
                RenewSubscriptionJob::dispatch($subscription);
            }
            catch (Exception $exception){
                $this->error($exception->getMessage());
            }
        }

        $this->info('Renewal jobs dispatched for ' . $dueSubscriptions->count() . ' subscriptions.');
    }
}
