<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'renewal_at' => 'required|date',
        ];
    }
}
