<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param int $userId
     * @return User
     */
    public function getUserWithDetails(int $userId): User
    {
        return User::with(['subscriptions', 'transactions'])->findOrFail($userId);
    }
}
