<?php

namespace App\Adapter\PaymentAdapters;

interface PaymentAdapterInterface
{

    /**
     * @param float $price
     * @return bool
     */
    public function pay(float $price): bool;
}
