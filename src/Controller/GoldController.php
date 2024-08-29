<?php
namespace App\Controller;

use App\Entity\Gold;
use App\Form\GuessType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class GoldController extends AbstractController
{
    #[Route('/game', name: 'app_gold')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $session = $request->getSession();

        // Chercher un jeu en cours pour l'utilisateur
        $gold = $entityManager->getRepository(Gold::class)
            ->findOneBy(['user' => $user, 'isOver' => false]);

        if (!$gold) {
            // Si aucun jeu en cours, créer un nouveau
            $gold = new Gold();
            $gold->setTargetNumber(rand(1, 79));
            $gold->setAttempts(0);
            $gold->setUser($user);
            $gold->setStartTime(new \DateTime());

            $entityManager->persist($gold);
            $entityManager->flush();
        }

        $form = $this->createForm(GuessType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$gold->getIsOver()) {
            $data = $form->getData();
            $guess = $data['guess'];

            $gold->setAttempts($gold->getAttempts() + 1);

            $response = [
                'success' => false,
                'message' => '',
                'isOver' => false,
                'elapsedTime' => null,
            ];

            if ($guess == $gold->getTargetNumber()) {
                // Obtenir le temps écoulé envoyé par le client
                $elapsedTime = $request->request->get('elapsedTime');
                $gold->setEndTime(new \DateTime());
                $gold->setDuration($elapsedTime > 0 ? (int)$elapsedTime : 1); // Utiliser le temps écoulé envoyé
                $gold->setIsOver(true);

                $this->addFlash('success', 'Félicitations ! Vous avez trouvé le chiffre en ' . $elapsedTime . ' secondes, bienvenue au 79 !');

                $response['success'] = true;
                $response['message'] = 'Félicitations ! Vous avez trouvé le chiffre en ' . $elapsedTime . ' secondes, bienvenue au 79 !';
                $response['isOver'] = true;
                $response['elapsedTime'] = $elapsedTime;
            } elseif ($guess < $gold->getTargetNumber()) {
                $this->addFlash('warning', 'Le chiffre est plus grand.');
                $response['message'] = 'Le chiffre est plus grand.';
            } else {
                $this->addFlash('warning', 'Le chiffre est plus petit.');
                $response['message'] = 'Le chiffre est plus petit.';
            }

            // Sauvegarder l'état du jeu après chaque tentative
            $entityManager->flush();

            // Si c'est une requête AJAX, on renvoie une réponse JSON
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse($response);
            }
        }

        // Récupérer les 3 meilleurs temps de l'utilisateur connecté
        $userBestTimes = $entityManager->getRepository(Gold::class)
            ->findBy(['user' => $user, 'isOver' => true], ['duration' => 'ASC'], 3);

        // Filtrer les durées valides
        $userBestTimes = array_filter($userBestTimes, function($game) {
            return $game->getDuration() > 0;
        });

        // Récupérer les meilleurs temps globaux
        $globalBestTimes = $entityManager->getRepository(Gold::class)
            ->findBy(['isOver' => true], ['duration' => 'ASC'], 10);

        return $this->render('gold/index.html.twig', [
            'form' => $form->createView(),
            'isOver' => $gold->getIsOver(),
            'userBestTimes' => $userBestTimes,
            'globalBestTimes' => $globalBestTimes,
        ]);
    }

    #[Route('/game/reset', name: 'app_gold_reset', methods: ['POST'])]
    public function resetGame(Request $request, EntityManagerInterface $entityManager, UserInterface $user): JsonResponse
    {
        $session = $request->getSession();

        // Supprimer le jeu en cours
        $gold = $entityManager->getRepository(Gold::class)
            ->findOneBy(['user' => $user, 'isOver' => false]);

        if ($gold) {
            $entityManager->remove($gold);
            $entityManager->flush();
        }

        // Réinitialiser la session
        $session->remove('startTime');

        // Vider les messages Flash
        $this->addFlash('info', 'Jeu réinitialisé. Vous pouvez recommencer.');

        return new JsonResponse(['status' => 'Game reset']);
    }
}
