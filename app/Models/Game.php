<?php

namespace App\Models;

class Game extends Model
{
    public string $id;
    public array $players = [];
    private array $playersScore = [];
    public string $name = '';
    private string $walkingPLayerId;

    /**
     * @return string
     */
    public function getWalkingPLayerId(): string
    {
        return $this->walkingPLayerId;
    }

    /**
     * @param string $walkingPLayerId
     */
    public function setWalkingPLayerId(string $walkingPLayerId): void
    {
        $this->walkingPLayerId = $walkingPLayerId;
    }

    /**
     * @return array
     */
    public function getPlayersScore(): array
    {
        return $this->playersScore;
    }

    /**
     * @param Player $player
     */
    public function getPlayerScore(Player $player): int
    {
        return $this->playersScore[$player->getId()];
    }

    /**
     * @param Player $player
     */
    public function setPlayerScore(Player $player): void
    {
        if (!isset($this->playersScore[$player->getId()])) {
            $this->playersScore[$player->getId()] = 1;
        } else {
            $this->playersScore[$player->getId()]++;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array $players
     */
    public function __construct(array $players = [], string $name = '')
    {
        $this->id = uniqid(more_entropy: true);
        $this->players = $players;
        $this->name = $name;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        foreach ($this->players as $person) {
            if ($person->getId() == $player->getId()) break;
        }
        $this->players[] = $player;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}