<?php

    namespace App\Http\Controllers;

    use AllowDynamicProperties;
    use App\Http\Resources\ProfileResource;
    use App\Http\Responses\ApiResponse;
    use App\Interfaces\ProfileRepositoryInterface;
    use Illuminate\Http\JsonResponse;

    #[AllowDynamicProperties] class ProfileController
    {
        public function __construct(ProfileRepositoryInterface $profileRepository)
        {
            $this->profileRepository = $profileRepository;
            $this->apiResponse = new ApiResponse();
        }

        public function index(): JsonResponse
        {

            $data = $this->profileRepository->index();

            return ApiResponse::success('Index of Profiles', 200, ProfileResource::collection($data));
        }
    }
