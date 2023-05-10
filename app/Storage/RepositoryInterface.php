<?php

namespace App\Storage;

use App\Models\Model;

interface RepositoryInterface
{
    public function get(string $id): ?Model;
    public function getAll(): array;
    public function save(Model $model);
}