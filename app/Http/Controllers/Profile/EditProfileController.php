<?php

    namespace App\Http\Controllers\Profile;

    use App\DataTransferObjects\ProfileDTO;
    use App\Enum\ProfileStatusEnum;
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
            $profileDTO = ProfileDTO::fromRequest($request);

            DB::beginTransaction();

            $edit = $profileRepository->edit($profileDTO);

            if ($edit) {
                DB::commit();
                return new ApiSuccessResponse(['lastname' => $profileDTO->lastname,
                    'firstname' => $profileDTO->firstname,
                    'avatar' => $profileDTO->avatar ?? null,
                    'status' => ProfileStatusEnum::from($profileDTO->statusId)->name],'Profile updated successfully', 200);
            }
            DB::rollBack();

           return new ApiErrorResponse("Profile update fail, check yours datas", throw new RequestException('Editing profile error profile error', 400, __FILE__, __LINE__));
        }
    }
