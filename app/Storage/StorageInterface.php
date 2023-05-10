<?php

namespace App\Storage;

interface StorageInterface
{
    public function connect(): bool;
    public function get(string $key);
    public function has(string $key): bool;
    public function put(string $key, $value);
    public function delete(string $key);
}