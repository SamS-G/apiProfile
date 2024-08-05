<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Requests\Profile\UpdateProfileRequest;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;

    class EditProfileController extends BaseController
    {
        /*
         * Update profile for administrator with valid token
         */
        public function edit(UpdateProfileRequest $request): JsonResponse
        {
            // Validate request data
            $dataToUpdate = [
                'id' => $request->validated('id'),
                'last_name' => $request->validated('lastname'),
                'first_name' => $request->validated('firstname'),
                "status" => $request->validated('status')
            ];

            DB::beginTransaction();

            $edit = $this->profileRepository->edit($dataToUpdate['id'], $dataToUpdate);

            if ($edit) {
                DB::commit();
                return ApiResponse::success('Profile updated successfully', 201, ['new_datas' => $dataToUpdate]);
            }

            DB::rollBack();
            $this->apiResponse->error("Profile update fail, check yours datas !", 500, ["data" => $dataToUpdate]);
        }
    }
