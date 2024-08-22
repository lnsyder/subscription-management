<?php

namespace App\Factory;

use App\Adapter\PaymentAdapters\IyzicoAdapter;
use App\Adapter\PaymentAdapters\PaymentAdapterInterface;
use App\Adapter\PaymentAdapters\StripeAdapter;
use App\Models\User;
use InvalidArgumentException;

class PaymentAdapterFactory
{
    public static function create(User $user): PaymentAdapterInterface
    {
        return match ($user->payment_provider) {
            'stripe' => new StripeAdapter(),
            'iyzico' => new IyzicoAdapter(),
            default => throw new InvalidArgumentException("Unknown payment method: {$user->payment_method}"),
        };
    }
}
