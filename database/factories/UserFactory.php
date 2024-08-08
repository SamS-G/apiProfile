<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $types = DB::table('user_type')->pluck('id');

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'user_type_id' => $this->faker->randomElement($types),
            'is_active' => $this->faker->boolean(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => '$2y$10$T4.bNcjQBiMqkDcPxoTzi.Ihrr5.HVLFCTN6p2NNeTg9kPB1gt67y',
        ];
    }
}
