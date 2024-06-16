<?php

    namespace App\Repository\User;

    use App\Interfaces\User\UserRepositoryInterface;
    use App\Models\User;
    use Illuminate\Support\Collection;

    class UserRepository implements UserRepositoryInterface
    {
        public function create(array $data): Collection
        {
            return User::create($data);
        }
    }
