<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Http\JsonResponse;

    class IndexProfileController extends BaseController
    {
        /*
         * Public endpoint, index of all active Profiles.
         * Column 'status' of profile not visible if current user don't use a valid token in the request
         */
        public function index(ProfileRepository $profileRepository): JsonResponse
        {

            $data = $profileRepository->index();

            return ApiSuccessResponse::success('Index of Profiles', 200, ProfileResource::collection($data));
        }
    }
