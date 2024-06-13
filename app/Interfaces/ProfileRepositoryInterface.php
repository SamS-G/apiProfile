<?php

namespace App\Interfaces;

interface ProfileRepositoryInterface
{
    public function index();
    public function getById($id);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
