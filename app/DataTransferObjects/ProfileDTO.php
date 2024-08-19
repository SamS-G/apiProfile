<?php

    namespace App\DataTransferObjects;

    use App\Http\Requests\Profile\CreateProfileRequest;

    readonly class ProfileDTO
    {
        public function __construct(
            public string $lastname,
            public string $firstname,
            public string $avatar,
            public int    $statusId,
        )
        {
        }

        public static function fromRequest(CreateProfileRequest $request): self
        {
            return new self(
                lastname: $request->input('last_name'),
                firstname: $request->input('first_name'),
                avatar: $request->input('avatar'),
                statusId: $request->input('status_id'),
            );
        }
    }
