<?php

    namespace App\Http\Controllers;

    use AllowDynamicProperties;
    use App\Http\Requests\CreateProfileRequest;
    use App\Http\Requests\UpdateProfileRequest;
    use App\Http\Resources\ProfileResource;
    use App\Http\Response\ApiResponse;
    use App\Interfaces\ProfileRepositoryInterface;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Throwable;

    #[AllowDynamicProperties] class ProfileController extends Controller
    {
        public function __construct(ProfileRepositoryInterface $profileRepository)
        {
            $this->profileRepository = $profileRepository;
        }

        public function index(): JsonResponse
        {
            $data = $this->profileRepository->index();

            return ApiResponse::success(ProfileResource::collection($data));
        }

        public function show($id): JsonResponse
        {
            $profile = $this->profileRepository->getById($id);

            return ApiResponse::success(new ProfileResource($profile));
        }

        public function create(CreateProfileRequest $request): JsonResponse
        {
            $data = [
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'avatar' => $request->avatar ?? null
            ];

            DB::beginTransaction();

            try {
                $profile = $this->profileRepository->create($data);

                DB::commit();

                return ApiResponse::success(new ProfileResource($profile), 'Profile created successfully.', 201);
            } catch (Throwable $t) {
                ApiResponse::fail($t);
            }
        }

        public function update($id, UpdateProfileRequest $request): JsonResponse
        {
            $dataUpdate = [
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'avatar' => $request->avatar ?? null
            ];

            DB::beginTransaction();

            try {
                $profile = $this->profileRepository->update($id, $dataUpdate);

                DB::commit();

                return ApiResponse::success(new ProfileResource($profile), 'Profile updated successfully.', 201);
            } catch (Throwable $t) {
                ApiResponse::fail($t);
            }
        }

        public function delete($id): JsonResponse
        {
            $this->profileRepository->delete($id);

            return ApiResponse::success(null, 'Profile deleted successfully.', 204);
        }
    }
