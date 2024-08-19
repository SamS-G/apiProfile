<?php

namespace App\Interfaces\Profile;

use App\DataTransferObjects\ProfileDTO;

interface ProfileRepositoryInterface
{
    public function index();
    public function getByName(array $names);
    public function create(ProfileDTO $profileDTO);
    public function edit(int $id, array $data);
    public function delete(int $id);
}
