<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'renewal_at' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
        ];
    }
}
