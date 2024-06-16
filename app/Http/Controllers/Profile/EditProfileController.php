<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Requests\Profile\UpdateProfileRequest;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;
    use Throwable;

    class EditProfileController extends BaseController
    {
        /*
         * Update profile for administrator with valid token
         */
        public function edit(UpdateProfileRequest $request): JsonResponse
        {
            $dataToUpdate = [
                'id' => $request->id,
                'last_name' => $request->lastname,
                'first_name' => $request->firstname,
                "status" => $request->status
            ];

            DB::beginTransaction();

            $edit = $this->profileRepository->edit($request->id, $dataToUpdate);

            if ($edit) {
                DB::commit();
                return ApiResponse::success('Profile updated successfully', 201, ['new_datas' => $dataToUpdate]);
            }

            DB::rollBack();
            $this->apiResponse->error("Profile update fail, check yours datas !", 500, ["data" => $dataToUpdate]);
        }
    }
