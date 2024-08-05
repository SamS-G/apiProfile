<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Requests\Profile\ShowProfileRequest;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;

    class ShowProfileController extends BaseController
    {
        /*
         * Search existing and active profile, secured.
         */
        public function showByName(ShowProfileRequest $request): JsonResponse
        {
            $names = [
                'lastname' => $request->validated('lastname'),
                'firstname' => $request->validated('firstname'),
            ];
            $profile = $this->profileRepository->getByName($names);

            if ($profile->isEmpty()) {
                return ApiResponse::error("No occurrence found, check yours datas", 404);
            }
            return ApiResponse::success(sprintf('%s%s', "Profile for user name = ", implode(" ", $names)), 200, ProfileResource::collection($profile));
        }
    }
