<?php
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
        "Je suis souvent associé à un jeu de cartes populaire.",
        "Mon nom évoque aussi un type de lien ou de connexion.",
        "Je suis parfois utilisé pour désigner un objet qui sert à sécuriser.",
        "Dans le monde nautique, je peux désigner une pièce d'équipement.",
        "On m'associe à un lieu où l'on peut jouer, souvent mentionné avec le mot 'porte'."
    ];

    public function startNewGame(): array
    {
        return [
            'word' => $this->word,
            'hints' => array_slice($this->hints, 0, 5),
            'remainingAttempts' => 10,
        ];
    }

    public function checkAnswer(string $answer, int $attemptsMade): array
    {
        $success = strtolower($answer) === strtolower($this->word);
        $remainingAttempts = 10 - $attemptsMade;

        // Montre les 5 premiers indices pour les 5 premières tentatives, puis tous les indices
        $hintsToShow = $attemptsMade < 5 ? array_slice($this->hints, 0, 5) : $this->hints;

        return [
            'success' => $success,
            'message' => $success ? "Félicitations, vous avez deviné le mot !" : "Incorrect. Il vous reste $remainingAttempts tentatives.",
            'remainingAttempts' => $remainingAttempts,
            'hints' => $hintsToShow,
        ];
    }
}
