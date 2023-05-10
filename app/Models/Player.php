<?php

namespace App\Models;

class Player extends Model
{
    public string $id;
    public string $name;
    private string $currentPageId = '';
    private string $targetPageId = '';

    /**
     * @return string
     */
    public function getCurrentPageId(): string
    {
        return $this->currentPageId;
    }

    /**
     * @param string $currentPageId
     */
    public function setCurrentPageId(string $currentPageId): void
    {
        $this->currentPageId = $currentPageId;
    }

    /**
     * @return string
     */
    public function getTargetPageId(): string
    {
        return $this->targetPageId;
    }

    /**
     * @param string $targetPageId
     */
    public function setTargetPageId(string $targetPageId): void
    {
        $this->targetPageId = $targetPageId;
    }

    /**
     * @param string $name
     */
    public function __construct(string $name, int $number)
    {
        $this->id = uniqid(more_entropy: true);
        $this->name = $name === '' ? 'Player ' . $number : $name;
    }

    /**
     * @return string
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


}