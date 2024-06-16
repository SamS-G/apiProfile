<?php

    namespace App\Http\Controllers;

    use AllowDynamicProperties;
    use App\Http\Responses\API\ApiResponse;
    use App\Interfaces\Profile\ProfileRepositoryInterface;

    #[AllowDynamicProperties] class BaseController
    {
        public function __construct(ProfileRepositoryInterface $profileRepository)
        {
            $this->profileRepository = $profileRepository;
            $this->apiResponse = new ApiResponse();
        }

    }
