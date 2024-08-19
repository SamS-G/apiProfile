<?php

    namespace App\Repository\User;

    use App\Interfaces\User\UserRepositoryInterface;
    use App\Models\User;

    class UserRepository implements UserRepositoryInterface
    {
        public function create(object $userDTO): User
        {
            return User::create([
                'name' => $userDTO->name,
                'email' => $userDTO->email,
                'password' => $userDTO->password,
                'user_type_id' => $userDTO->userTypeId,
                'is_active' => $userDTO->isActive,
            ]);
        }
    }
