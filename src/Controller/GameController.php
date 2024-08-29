<?php
// src/Controller/GameController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GameService;
use Symfony\Component\Security\Core\User\UserInterface;

class GameController extends AbstractController
{
    #[Route('/start-game', name: 'start_game')]
    public function startGame(GameService $gameService, SessionInterface $session, UserInterface $user = null): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            // Rediriger vers la page de login si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        // Initialisation de la partie
        $gameData = $gameService->startNewGame();
        $session->set('remainingAttempts', $gameData['remainingAttempts']);
        $session->set('attemptsMade', 0);

        return $this->render('game/start.html.twig', [
            'gameData' => $gameData,
        ]);
    }

    #[Route('/play-game', name: 'play_game', methods: ['POST'])]
    public function playGame(Request $request, GameService $gameService, SessionInterface $session, UserInterface $user = null): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            // Rediriger vers la page de login si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        $answer = $request->request->get('answer');
        $attemptsMade = $session->get('attemptsMade') + 1;
        $session->set('attemptsMade', $attemptsMade);

        $result = $gameService->checkAnswer($answer, $attemptsMade);

        return $this->render('game/result.html.twig', [
            'result' => $result,
        ]);
    }
}
