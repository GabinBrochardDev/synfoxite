<?php

namespace App\Entity;

use App\Repository\GuirlandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuirlandeRepository::class)]
class Guirlande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $grid = null;   // Grille de mots

    #[ORM\Column(type: Types::TEXT)]
    private ?string $availableLetters = null; // Lettres disponibles

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $foundWords = null; // Liste des mots à trouvés

    public function __construct()
    {
        $this->foundWords = json_encode([]);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGrid(): ?string
    {
        return $this->grid;
    }

    public function setGrid(string $grid): static
    {
        $this->grid = $grid;

        return $this;
    }

    public function getAvailableLetters(): ?string
    {
        return $this->availableLetters;
    }

    public function setAvailableLetters(string $availableLetters): static
    {
        $this->availableLetters = $availableLetters;

        return $this;
    }

    // public function getFoundWords(): ?string
    // {
    //     return $this->foundWords;
    // }

    public function setFoundWords(?string $foundWords): static
    {
        $this->foundWords = $foundWords;

        return $this;
    }

    public function addFoundWord(string $word): void
    {
        $word = json_decode($this->foundWords, true);
        $word[] = $word;
        $this->foundWords = json_encode($word);
    }


    public function getFoundWords(): array
    {
        return json_decode($this->foundWords, true);
    }

    public function canFormWord(string $word): bool
    {
        $letterCounts = array_count_values(str_split(strtolower($word)));
        $wordCounts = array_count_values(str_split(strtolower($word)));

        foreach ($wordCounts as $letter => $count) {
            if (!isset($letterCounts[$letter]) || $letterCounts[$letter] < $count) {
                return false;
            }
        }

        return true;
    }

}
