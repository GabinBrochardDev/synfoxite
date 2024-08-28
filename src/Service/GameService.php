<?php
// src/Service/GameService.php

namespace App\Service;

class GameService
{
    private string $word = 'manille';
    private array $hints = [
        "Je suis un mot de 7 lettres.",
        "On me trouve dans une expression qui décrit un petit jeu de cartes.",
        "Je peux être joué à quatre personnes.",
        "Je suis aussi le nom d'une capitale.",
        "Mon nom peut également désigner une pièce d'équipement utilisée dans l'escalade.",
        "Mon nom évoque aussi un type de lien ou de connexion.",
        "Je suis parfois utilisé pour désigner un objet qui sert à sécuriser.",
        "Dans le monde nautique, je peux désigner une pièce d'équipement.",
    ];

    private int $maxAttempts = 10;

    public function startNewGame(): array
    {
        // Initialisation des données de jeu
        return [
            'hints' => array_slice($this->hints, 0, 5),
            'remainingAttempts' => $this->maxAttempts,
        ];
    }

    public function checkAnswer(string $answer, int $attemptsMade): array
    {
        if (strtolower($answer) === $this->word) {
            return ['success' => true, 'message' => 'Félicitations, vous avez deviné le mot !'];
        }

        $remainingAttempts = $this->maxAttempts - $attemptsMade;
        $hintsToShow = $attemptsMade >= 5 ? array_slice($this->hints, 0, 10) : array_slice($this->hints, 0, 5);

        if ($remainingAttempts > 0) {
            return [
                'success' => false,
                'message' => "Incorrect. Il vous reste $remainingAttempts tentatives.",
                'remainingAttempts' => $remainingAttempts,
                'hints' => $hintsToShow
            ];
        }

        return [
            'success' => false,
            'message' => "Dommage, tu as perdu. Le mot était '{$this->word}'.",
            'remainingAttempts' => 0,
            'hints' => $hintsToShow
        ];
    }
}

