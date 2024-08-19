<?php

    namespace App\Interfaces\User;

    use App\DataTransferObjects\UserDTO;
    use App\Models\User;

    interface UserRepositoryInterface
    {
        public function create(UserDTO $userDTO): User;
    }
