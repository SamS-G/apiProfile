<?php

    namespace App\Repository;

    use App\Interfaces\ProfileRepositoryInterface;
    use App\Models\Profile;
    use Illuminate\Database\Eloquent\Collection;

    class ProfileRepository implements ProfileRepositoryInterface
    {
        public function index(): Collection
        {
            return Profile::all();
        }

        public function getById($id)
        {
            return Profile::findOrFail($id);
        }

        public function create(array $data)
        {
            return Profile::create($data);
        }

        public function update(array $data, $id)
        {
            return Profile::whereId($id)->update($data);
        }

        public function delete($id): int
        {
            return Profile::destroy($id);
        }
    }
