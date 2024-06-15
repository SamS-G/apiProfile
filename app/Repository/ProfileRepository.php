<?php

    namespace App\Repository;

    use App\Http\Responses\ApiResponse;
    use App\Interfaces\ProfileRepositoryInterface;
    use App\Models\Profile;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Http\JsonResponse;

    class ProfileRepository implements ProfileRepositoryInterface
    {
        public function index(): Collection
        {
            return Profile::where('status', 'actif')->get();
        }

        public function getByName(array $names): Profile
        {
            return Profile::where('last_name', 'like', $names['lastname'])
                ->where('first_name', 'like', $names['firstname'])
                ->firstOrFail();
        }

        public function create(array $data)
        {
            return Profile::create($data);
        }

        public function edit($id, $data)
        {
            return Profile::whereId($id)->update($data);
        }

        public function delete($id): JsonResponse
        {
            if (Profile::destroy($id)) {
                return ApiResponse::success('Profile deleted successfully', 204, ['user_deleted_id' => $id]);
            }
            return ApiResponse::error('Profile could not be deleted', 500);

        }
    }
