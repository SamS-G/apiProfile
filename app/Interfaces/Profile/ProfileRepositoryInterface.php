<?php

namespace App\Interfaces\Profile;

interface ProfileRepositoryInterface
{
    public function index();
    public function getByName(array $names);
    public function create(array $data);
    public function edit(int $id, array $data);
    public function delete(int $id);
}
