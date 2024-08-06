<?php

    namespace App\Http\Controllers\Profile;

    use App\Http\Exceptions\RequestException;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Repository\Profile\ProfileRepository;
    use Illuminate\Validation\ValidationException;
    use Symfony\Component\HttpFoundation\Request;

    class DeleteProfileController
    {
        /*
         * Delete profile for administrator with valid token
         */
        /**
         * @throws ValidationException
         * @throws RequestException
         */
        public function delete(Request $request, int $id, ProfileRepository $profileRepository): ApiErrorResponse|ApiSuccessResponse
        {
            validator($request->route()->parameters(), [
                "id" => "required",
            ])->validate();

            $destroy = $profileRepository->delete($id);

            if ($destroy) {
                return new ApiSuccessResponse([], 'Profile deleted successfully', 204);
            }
            return new ApiErrorResponse('Profile could not be deleted, check yours params', throw new RequestException('Deleting profile error', 400, __FILE__, __LINE__));
        }
    }
