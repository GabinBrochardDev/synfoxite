<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Gold
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $targetNumber = null;

    #[ORM\Column(type: 'integer')]
    private ?int $attempts = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isOver = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $duration = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'golds')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetNumber(): ?int
    {
        return $this->targetNumber;
    }

    public function setTargetNumber(int $targetNumber): self
    {
        $this->targetNumber = $targetNumber;

        return $this;
    }

    public function getAttempts(): ?int
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

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(?\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
