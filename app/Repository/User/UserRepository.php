<?php

    namespace App\Repository\User;

    use App\Interfaces\User\UserRepositoryInterface;
    use App\Models\User;
  
    class UserRepository implements UserRepositoryInterface
    {
        public function create(array $data): User
        {
            return User::create($data);
        }
    }
