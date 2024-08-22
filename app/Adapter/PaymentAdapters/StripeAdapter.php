<?php

namespace App\Adapter\PaymentAdapters;

class StripeAdapter implements PaymentAdapterInterface
{
    /**
     * @param float $price
     * @return bool
     */
    public function pay(float $price): bool
    {
        return true;
    }
}
