<?php

namespace App\Entity;

use App\Repository\GoldRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoldRepository::class)]
class Gold
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $targetNumber;

    #[ORM\Column(type: 'integer')]
    private int $attempts;

    #[ORM\Column(type: 'boolean')]
    private bool $isOver = false;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetNumber(): int
    {
        return $this->targetNumber;
    }

    public function setTargetNumber(int $targetNumber): self
    {
        $this->targetNumber = $targetNumber;

        return $this;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts): self
    {
        $this->attempts = $attempts;

        return $this;
    }

    public function getIsOver(): bool
    {
        return $this->isOver;
    }

    public function setIsOver(bool $isOver): self
    {
        $this->isOver = $isOver;

        return $this;
    }
}
