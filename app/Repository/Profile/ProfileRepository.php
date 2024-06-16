<?php

    namespace App\Repository\Profile;

    use App\Http\Responses\API\ApiResponse;
    use App\Interfaces\Profile\ProfileRepositoryInterface;
    use App\Models\Profile;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Http\JsonResponse;

    class ProfileRepository implements ProfileRepositoryInterface
    {
        public function index(): Collection
        {
            return Profile::where('status', 'actif')->get();
        }

        public function getByName(array $names): \Illuminate\Support\Collection
        {
            return collect(Profile::where('last_name', 'like', $names['lastname'])
                ->where('first_name', 'like', $names['firstname'])
                ->get());
        }

        public function create(array $data)
        {
            return Profile::create($data);
        }

        public function edit($id, $data): int
        {
            return Profile::whereId($id)->update($data);
        }

        public function delete($id): int
        {
            return Profile::destroy($id);
        }
    }
