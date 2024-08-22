<?php

namespace App\Services;

use App\Factory\PaymentAdapterFactory;
use App\Models\Transaction;
use App\Models\User;
use Exception;

class TransactionService
{
    /**
     * @param User $user
     * @param array $data
     * @return Transaction
     * @throws Exception
     */
    public function create(User $user, array $data): Transaction
    {
        $paymentAdapter = PaymentAdapterFactory::create($user);
        $data['price'] = $data['price'] ?? 100;
        $success = $paymentAdapter->pay($data['price']);

        if (!$success) {
            throw new Exception('Payment process is failed');
        }

        $user->subscriptions()->update(["renewal_at" => now()->addMonth()]);

        return $user->transactions()->create($data);
    }
}
