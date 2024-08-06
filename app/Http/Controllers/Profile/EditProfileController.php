<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Exceptions\RequestException;
    use App\Http\Requests\Profile\UpdateProfileRequest;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Support\Facades\DB;

    class EditProfileController
    {
        /*
         * Update profile for administrator with valid token
         */
        /**
         * @throws RequestException
         */
        public function edit(UpdateProfileRequest $request, ProfileRepository $profileRepository): ApiSuccessResponse|ApiErrorResponse
        {
            // Validate request data
            $dataToUpdate = [
                'id' => $request->validated('id'),
                'last_name' => $request->validated('lastname'),
                'first_name' => $request->validated('firstname'),
                "status" => $request->validated('status')
            ];

            DB::beginTransaction();

            $edit = $profileRepository->edit($dataToUpdate['id'], $dataToUpdate);

            if ($edit) {
                DB::commit();
                return new ApiSuccessResponse(['new_datas' => $dataToUpdate],'Profile updated successfully', 201);
            }
            DB::rollBack();

           return new ApiErrorResponse("Profile update fail, check yours datas !", throw new RequestException('Editing profile error profile error', 400, __FILE__, __LINE__));
        }
    }
