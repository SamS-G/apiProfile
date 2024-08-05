<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Controllers\BaseController;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use Symfony\Component\HttpFoundation\Request;

    class DeleteProfileController extends BaseController
    {
        /*
         * Delete profile for administrator with valid token
         */
        /**
         * @throws ValidationException
         */
        public function delete(Request $request, int $id, ProfileRepository $profileRepository): JsonResponse
        {
            validator($request->route()->parameters(), [
                "id" => "required",
            ])->validate();


            $destroy = $profileRepository->delete($id);

            if ($destroy) {
                return ApiSuccessResponse::success('Profile deleted successfully', 204, ['user_deleted_id' => $id]);
            }
            return ApiSuccessResponse::error('Profile could not be deleted, check yours params', 500);
        }
    }
