<?php

    namespace Database\Factories;

    use App\Models\ProfileStatus;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class ProfileStatusFactory extends Factory
    {
        protected $model = ProfileStatus::class;
        public function definition(): array
        {
            return [
                'status' => $this->faker->unique()->randomElement(["Active","Inactive","Deleted","Pending"])
            ];
        }
    }
