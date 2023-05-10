<?php
namespace App\Storage\Session;

use App\Storage\StorageInterface;

class Storage implements StorageInterface
{
    public function __construct()
    {
        if ($this->connect()) {
            $this->initGamesTable();
        }
    }

    public function connect(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key)
    {
        return $this->has($key) ? $_SESSION[$key] : null;
    }

    public function put(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }

    private function initGamesTable(): void
    {
        if (!isset($_SESSION['games']) || !is_array($_SESSION['games'])) {
            $_SESSION['games'] = [];
        }
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}