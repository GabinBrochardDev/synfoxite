<?php
namespace App\Controller;

use App\Entity\Gold;
use App\Form\GuessType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoldController extends AbstractController
{
    #[Route('/Game', name: 'app_Gold')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // On initialise ou récupère le jeu
        $Gold = new Gold();
        $Gold->setTargetNumber(rand(1, 100));
        $Gold->setAttempts(0);

        $form = $this->createForm(GuessType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$Gold->getIsOver()) {
            $data = $form->getData();
            $guess = $data['guess'];

            $Gold->setAttempts($Gold->getAttempts() + 1);

            if ($guess == $Gold->getTargetNumber()) {
                $this->addFlash('success', 'Félicitations ! Vous avez trouvé le chiffre en ' . $Gold->getAttempts() . ' tentatives.');
                $Gold->setIsOver(true);
            } elseif ($Gold->getAttempts() >= 10) {
                $this->addFlash('danger', 'Désolé, vous avez atteint le nombre maximum de tentatives. Le chiffre était ' . $Gold->getTargetNumber() . '.');
                $Gold->setIsOver(true);
            } elseif ($guess < $Gold->getTargetNumber()) {
                $this->addFlash('warning', 'Le chiffre est plus grand.');
            } else {
                $this->addFlash('warning', 'Le chiffre est plus petit.');
            }

            // Redirection après la soumission
            return $this->redirectToRoute('app_Gold');
        }

        return $this->render('Gold/index.html.twig', [
            'form' => $form->createView(),
            'isOver' => $Gold->getIsOver(),
            'attempts' => $Gold->getAttempts(),
        ]);
    }
}
