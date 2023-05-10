<?php

namespace App\Storage\Session;

use App\Models\Game;
use App\Models\Model;
use App\Storage\RepositoryInterface;
use App\Storage\StorageInterface;

class GameRepository implements RepositoryInterface
{
    private StorageInterface $storage;

    public function __construct()
    {
        $this->storage = new Storage();
    }

    public function get(string $id): ?Model
    {
        $games = $this->getAll();
        if (isset($games[$id])) {
            return $games[$id];
        }
        return null;
    }

    public function getAll(): array
    {
        return $this->storage->get('games');
    }

    public function save(Game|Model $model)
    {
        $games = $this->getAll();
        $games[$model->getId()] = $model;
        $this->storage->put('games', $games);
    }
}