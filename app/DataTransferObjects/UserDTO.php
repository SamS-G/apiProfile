<?php

    namespace App\DataTransferObjects;

    use App\Enum\UserTypeEnum;
    use App\Http\Requests\Authenticate\RegisterRequest;
    use Illuminate\Validation\Rule;

    readonly class UserDTO
    {
        public function __construct(
            public string $name,
            public string $email,
            public string $userTypeId,
            public bool   $isActive,
            public string $password
        )
        {
        }

        public static function fromRequest(RegisterRequest $request): self
        {
            return new self(
                name: $request['name'],
                email: $request['email'],
                userTypeId: $request['userType'],
                isActive: $request['isActive'],
                password: bcrypt($request['password']),
            );
        }
    }
