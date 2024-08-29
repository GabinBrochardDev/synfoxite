<?php
namespace App\Controller;

use App\Entity\Guirlande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RpsController extends AbstractController
{
    #[Route('/677569726c616e6465', name: 'app_rps')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $choices = ['Pierre', 'Papier', 'Ciseaux'];
        $userChoice = $request->query->get('choice');
        $computerChoice = $choices[array_rand($choices)];

        $result = '';
        $guirlandes = [];

        if ($userChoice) {
            $result = $this->determineWinner($userChoice, $computerChoice);

            if ($result === 'Vous avez gagné !') {
                // Récupérer les enregistrements de la table "guirlande"
                $guirlandes = $entityManager->getRepository(Guirlande::class)->findAll();
            }
        }

        return $this->render('rps/index.html.twig', [
            'choices' => $choices,
            'userChoice' => $userChoice,
            'computerChoice' => $computerChoice,
            'result' => $result,
            'guirlandes' => $guirlandes,
        ]);
    }

    private function determineWinner(string $userChoice, string $computerChoice): string
    {
        if ($userChoice === $computerChoice) {
            return 'Égalité !';
        }

        if (
            ($userChoice === 'Pierre' && $computerChoice === 'Ciseaux') ||
            ($userChoice === 'Papier' && $computerChoice === 'Pierre') ||
            ($userChoice === 'Ciseaux' && $computerChoice === 'Papier')
        ) {
            return 'Vous avez gagné !';
        }

        return 'L\'ordinateur a gagné !';
    }
}
