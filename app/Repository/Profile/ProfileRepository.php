<?php

    namespace App\Repository\Profile;

    use App\DataTransferObjects\ProfileDTO;
    use App\Enum\ProfileStatusEnum;
    use App\Interfaces\Profile\ProfileRepositoryInterface;
    use App\Models\Profile;
    use Illuminate\Database\Eloquent\Collection;

    class ProfileRepository implements ProfileRepositoryInterface
    {
        public function index(): Collection
        {
            return Profile::where('status_id', ProfileStatusEnum::active)->get();
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

        public function edit($id, $data): int
        {
            return Profile::whereId($id)->update($data);
        }

        public function delete($id): int
        {
            return Profile::destroy($id);
        }
    }
