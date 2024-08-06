<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Requests\Profile\ShowProfileRequest;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;

    class ShowProfileController
    {
        /*
         * Search existing and active profile, secured.
         */
        public function showByName(ShowProfileRequest $request, ProfileRepository $profileRepository): ApiErrorResponse|ApiSuccessResponse
        {
            $names = [
                'lastname' => $request->validated('lastname'),
                'firstname' => $request->validated('firstname'),
            ];
            $profile = $profileRepository->getByName($names);

            if ($profile->isEmpty()) {
                return new ApiErrorResponse("No occurrence found, check yours datas", null, 404);
            }
            return new ApiSuccessResponse(ProfileResource::collection($profile), sprintf('%s%s', "Profile for user name = ", implode(" ", $names)));
        }
    }
