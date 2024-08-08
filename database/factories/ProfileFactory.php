<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $status = DB::table('profile_status')->pluck('id');

        return [
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'avatar' => $this->faker->filePath(),
            'status_id' => $this->faker->randomElement($status),
        ];
    }
}
