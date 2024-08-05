<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Requests\Profile\ShowProfileRequest;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Http\JsonResponse;

    class ShowProfileController extends BaseController
    {
        /*
         * Search existing and active profile, secured.
         */
        public function showByName(ShowProfileRequest $request, ProfileRepository $profileRepository): JsonResponse
        {
            $names = [
                'lastname' => $request->validated('lastname'),
                'firstname' => $request->validated('firstname'),
            ];
            $profile = $profileRepository->getByName($names);

            if ($profile->isEmpty()) {
                return ApiSuccessResponse::error("No occurrence found, check yours datas", 404);
            }
            return ApiSuccessResponse::success(sprintf('%s%s', "Profile for user name = ", implode(" ", $names)), 200, ProfileResource::collection($profile));
        }
    }
