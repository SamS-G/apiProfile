<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;

    class IndexProfileController extends BaseController
    {
        public function index(): JsonResponse
        {

            $data = $this->profileRepository->index();

            return ApiResponse::success('Index of Profiles', 200, ProfileResource::collection($data));
        }
    }
