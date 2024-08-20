<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Throwable;

    class IndexProfileController
    {
        /*
         * Public endpoint, index of all active Profiles.
         * Column 'status' of profile not visible if current user don't use a valid token in the request
         */
        public function index(ProfileRepository $profileRepository): ApiErrorResponse|ApiSuccessResponse
        {
            try {
                $data = $profileRepository->index();

                if ($data->count() > 0) {
                    return new ApiSuccessResponse($data, 'Index of Profiles', 200);
                }
                 return new ApiSuccessResponse([], 'Index of Profiles is empty', 204);

            } catch (Throwable $t) {
                return new ApiErrorResponse($t->getMessage(), $t);
            }
        }
    }
