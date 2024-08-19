<?php

    namespace App\DataTransferObjects;

    use App\Http\Requests\Profile\CreateProfileRequest;

    readonly class ProfileDTO
    {
        public function __construct(
            public string $lastname,
            public string $firstname,
            public mixed $avatar,
            public int    $statusId,
        )
        {
        }

        public static function fromRequest(CreateProfileRequest $request): self
        {
            return new self(
                lastname: $request->input('lastname'),
                firstname: $request->input('firstname'),
                avatar: $request->input('avatar'),
                statusId: $request->input('status'),
            );
        }
    }
