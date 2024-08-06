<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Requests\Profile\CreateProfileRequest;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Support\Facades\DB;
    use Throwable;

    class CreateProfileController
    {
        /*
         * Create new profile for administrator with valid token
         */
        public function create(CreateProfileRequest $request, ProfileRepository $profileRepository): ApiErrorResponse|ApiSuccessResponse
        {
            // Get and validate data
            $data = [
                'last_name' => $request->validated('lastname'),
                'first_name' => $request->validated('firstname'),
                'status' => $request->validated('status')
            ];

            DB::beginTransaction();

            try {
                $profileRepository->create($data);

                DB::commit();

                return new ApiSuccessResponse(['new_user_data' => $data], 'Profile created successfully', 201);

            } catch (Throwable $t) {
                DB::rollBack();

                return new ApiErrorResponse('An error occurred while creating your new profile', $t);
            }
        }
    }
