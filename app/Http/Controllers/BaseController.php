<?php

    namespace App\Http\Controllers;

    use App\Http\Responses\API\ApiResponse;
    use App\Interfaces\Profile\ProfileRepositoryInterface;

    class BaseController
    {
        public ProfileRepositoryInterface $profileRepository;
        public apiResponse $apiResponse;

        public function __construct(ProfileRepositoryInterface $profileRepository)
        {
            $this->profileRepository = $profileRepository;
            $this->apiResponse = new ApiResponse();
        }
    }
