<?php

    namespace App\Repository\Profile;

    use App\DataTransferObjects\ProfileDTO;
    use App\Enum\ProfileStatusEnum;
    use App\Http\Resources\Profile\ProfileResource;
    use App\Interfaces\Profile\ProfileRepositoryInterface;
    use App\Models\Profile;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

    class ProfileRepository implements ProfileRepositoryInterface
    {
        public function index(): AnonymousResourceCollection
        {
            $profiles = Profile::where('status_id', ProfileStatusEnum::active)->paginate(15);

            return ProfileResource::collection($profiles)->additional([
                'meta' => [
                    'total' => $profiles->total(),
                    'page' => $profiles->currentPage(),
                ],
                'links' => [
                    'self' => $profiles->url($profiles->currentPage()),
                    'next' => $profiles->nextPageUrl(),
                ]
            ]);
        }

        public function getByName(array $names): \Illuminate\Support\Collection
        {
            return collect(Profile::where('last_name', 'like', $names['lastname'])
                ->where('first_name', 'like', $names['firstname'])
                ->where('status', 'actif')
                ->get());
        }

        public function create(ProfileDTO $profileDTO)
        {
            return Profile::create([
                'last_name' => $profileDTO->lastname,
                'first_name' => $profileDTO->firstname,
                'avatar' => $profileDTO->avatar,
                'status_id' => $profileDTO->statusId
            ]);
        }

        public function edit(ProfileDTO $profileDTO)
        {
            return Profile::whereId($profileDTO->id)->update([
                'id' => $profileDTO->id,
                'last_name' => $profileDTO->lastname,
                'first_name' => $profileDTO->firstname,
                'avatar' => $profileDTO->avatar,
                'status_id' => $profileDTO->statusId
            ]);
        }

        public function delete($id): int
        {
            return Profile::destroy($id);
        }
    }
