<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subscription_id' => 'required|exists:subscriptions,id',
            'price' => 'required|numeric',
        ];
    }
}
