<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Requests\Profile\CreateProfileRequest;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;
    use Throwable;

    class CreateProfileController  extends BaseController
    {
        /*
         * Create new profile for administrator with valid token
         */
        public function create(CreateProfileRequest $request): JsonResponse
        {
            // Get and validate data
            $data = [
                'last_name' => $request->validated('lastname'),
                'first_name' => $request->validated('firstname'),
                'status' => $request->validated('status')
            ];

            DB::beginTransaction();

            try {
                $this->profileRepository->create($data);

                DB::commit();

                return ApiResponse::success('Profile created successfully', 201, [
                    'new_user_data' => $data
                ]);
            } catch (Throwable $t) {
                DB::rollBack();
                $this->apiResponse->error($t->getMessage(), 500, [$t->getTraceAsString()]);
            }
        }
    }
