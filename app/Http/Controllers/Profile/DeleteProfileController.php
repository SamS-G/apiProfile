<?php

    namespace App\Http\Controllers\Profile;

    use AllowDynamicProperties;
    use App\Http\Controllers\BaseController;
    use App\Http\Responses\API\ApiResponse;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use Symfony\Component\HttpFoundation\Request;

    #[AllowDynamicProperties] class DeleteProfileController extends BaseController
    {
        /*
         * Delete profile for administrator with valid token
         */
        /**
         * @throws ValidationException
         */
        public function delete(Request $request, int $id): JsonResponse
        {
            validator($request->route()->parameters(), [
                "id" => "required",
            ])->validate();


            $destroy = $this->profileRepository->delete($id);

            if ($destroy) {
                return ApiResponse::success('Profile deleted successfully', 204, ['user_deleted_id' => $id]);
            }
            return ApiResponse::error('Profile could not be deleted, check yours params', 500);
        }
    }
