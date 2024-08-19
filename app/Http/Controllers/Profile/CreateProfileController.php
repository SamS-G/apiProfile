<?php

    namespace App\Http\Controllers\Profile;

    use App\DataTransferObjects\ProfileDTO;
    use App\Enum\ProfileStatusEnum;
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

            $profileDTO = ProfileDTO::fromRequest($request);

            DB::beginTransaction();

            try {
                $profileRepository->create($profileDTO);

                DB::commit();

                return new ApiSuccessResponse([
                    'lastname' => $profileDTO->lastname,
                    'firstname' => $profileDTO->firstname,
                    'avatar' => $profileDTO->avatar ?? null,
                    'status' => ProfileStatusEnum::from($profileDTO->statusId)->name
                ],
                    'Profile created successfully', 201);

            } catch (Throwable $t) {
                DB::rollBack();

                return new ApiErrorResponse('An error occurred while creating your new profile', $t);
            }
        }
    }
