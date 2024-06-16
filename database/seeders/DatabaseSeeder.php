<?php
    namespace Database\Seeders;

    use App\Models\Profile;
    use App\Models\User;
    use App\Models\UserType;
    use Illuminate\Database\Seeder;

    final class DatabaseSeeder extends Seeder
    {
        public function run(): void
        {
            UserType::factory()->count(2)->create();
            User::factory()->count(10)->create();
            Profile::factory()->count(20)->create();
        }
    }
