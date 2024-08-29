<?php
// src/Controller/GameController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GameService;

class GameController extends AbstractController
{
    #[Route('/start-game', name: 'start_game')]
    public function startGame(GameService $gameService, SessionInterface $session): Response
    {
        // Initialisation de la partie
        $gameData = $gameService->startNewGame();
        $session->set('remainingAttempts', $gameData['remainingAttempts']);
        $session->set('attemptsMade', 0);

        return $this->render('game/start.html.twig', [
            'gameData' => $gameData,
        ]);
    }

    #[Route('/play-game', name: 'play_game', methods: ['POST'])]
    public function playGame(Request $request, GameService $gameService, SessionInterface $session): Response
    {
        $answer = $request->request->get('answer');
        $attemptsMade = $session->get('attemptsMade') + 1;
        $session->set('attemptsMade', $attemptsMade);

        $result = $gameService->checkAnswer($answer, $attemptsMade);

        return $this->render('game/result.html.twig', [
            'result' => $result,
        ]);
    }
}
