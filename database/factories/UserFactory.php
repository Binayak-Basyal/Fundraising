<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $names = [
            ['first' => 'Rekha', 'last' => 'Shrestha'],
            ['first' => 'Rajesh', 'last' => 'Bhandari'],
            ['first' => 'Nisha', 'last' => 'Adhikari'],
            ['first' => 'Amit', 'last' => 'Baral'],
            ['first' => 'Rina', 'last' => 'Chaudhary'],
            ['first' => 'Suman', 'last' => 'Rai'],
            ['first' => 'Kiran', 'last' => 'Ghimire'],
            ['first' => 'Maya', 'last' => 'Basnet'],
            ['first' => 'Suraj', 'last' => 'Poudel'],
            ['first' => 'Deepa', 'last' => 'Gurung'],
            ['first' => 'Bishal', 'last' => 'Kandel'],
            ['first' => 'Kavita', 'last' => 'Magar'],
            ['first' => 'Mohan', 'last' => 'Khadka'],
            ['first' => 'Priya', 'last' => 'Tamang'],
            ['first' => 'Ramesh', 'last' => 'Malla'],
            ['first' => 'Sunita', 'last' => 'Luitel'],
            ['first' => 'Rohit', 'last' => 'Rathi'],
            ['first' => 'Shree', 'last' => 'Kunwar'],
            ['first' => 'Pooja', 'last' => 'Sharma'],
            ['first' => 'Tika', 'last' => 'Tamrakar'],
            ['first' => 'Binod', 'last' => 'Sitaula'],
            ['first' => 'Aarti', 'last' => 'Basnet'],
            ['first' => 'Prabhat', 'last' => 'Singh'],
            ['first' => 'Laxmi', 'last' => 'Bhattarai'],
            ['first' => 'Gita', 'last' => 'Dhakal'],
            ['first' => 'Sagar', 'last' => 'Chhetri'],
            ['first' => 'Sonam', 'last' => 'Magar'],
            ['first' => 'Ranjan', 'last' => 'Kumar'],
            ['first' => 'Sheetal', 'last' => 'Thapa'],
            ['first' => 'Anup', 'last' => 'Shrestha'],
            ['first' => 'Tsering', 'last' => 'Tamang'],
            ['first' => 'Radhika', 'last' => 'Aryal'],
            ['first' => 'Surya', 'last' => 'Jha'],
            ['first' => 'Jaya', 'last' => 'Chaudhary'],
            ['first' => 'Kedar', 'last' => 'Pandey'],
            ['first' => 'Dipesh', 'last' => 'Bhatta'],
            ['first' => 'Sushila', 'last' => 'Thapa'],
            ['first' => 'Chandra', 'last' => 'Joshi'],
            ['first' => 'Jyoti', 'last' => 'Koirala'],
            ['first' => 'Nirmal', 'last' => 'Shrestha'],
            ['first' => 'Rupa', 'last' => 'Chhetri'],
            ['first' => 'Krishna', 'last' => 'Baral'],
            ['first' => 'Priyanka', 'last' => 'Rai'],
            ['first' => 'Rakesh', 'last' => 'Kunwar'],
            ['first' => 'Anjali', 'last' => 'Ghimire'],
            ['first' => 'Gaurav', 'last' => 'Sharma'],
        ];

        $index = $this->faker->numberBetween(0, count($names) - 1);
        $name = $names[$index];

        return [
            'first_name' => $name['first'],
            'last_name' => $name['last'],
            'phone' => $this->faker->unique()->phoneNumber,
            'address' => $this->faker->address,
            'email' => strtolower($name['first']) . '.' . strtolower($name['last']) . '@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Simple random password
            'remember_token' => Str::random(10),
            'dob' => $this->faker->date('Y-m-d', '2002-01-01'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'user_pic' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement([0, 1]),
            'admin_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}