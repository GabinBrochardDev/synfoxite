<?php

namespace App\Controller;

use App\Form\ImagimotType;
use App\ImagimotService\ImagimotService;
use App\Repository\GrassouilletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class GrassouilletController extends AbstractController
{
    #[Route('/imagimot', name: 'app_imagimot')]
    public function index(SessionInterface $session, GrassouilletRepository $grassouilletRepository): Response
    {
        // Set the session with attributes
        if ($session->get('arrayImagimot') === null && empty($session->get('arrayImagimot'))) {
            $arrayImagimot = $grassouilletRepository->findAll();
            shuffle($arrayImagimot);
            $session->set('arrayImagimot', $arrayImagimot);
        }
        if ($session->get('attemptsImagimot') === null && empty($session->get('attemptsImagimot'))) {
            $session->set('attemptsImagimot', 1);
        }

        // dd($session, $session->get('arrayImagimot')[$session->get('attemptsImagimot')], count($session->get('arrayImagimot')), $session->get('attemptsImagimot') + 1);

        return $this->render('grassouillet/index.html.twig', [
            'title' => 'Imagimot',
            'arrayImagimot' => $session->get('arrayImagimot'),
            'attemptsImagimot' => $session->get('attemptsImagimot'),
            'message' => 'Bravo ! Vous avez trouvé tous les animaux. Devinez maintenant le mot caché.'
        ]);
    }

    #[Route('/imagimot/game', name: 'app_imagimot_game')]
    public function form(Request $request, SessionInterface $session, GrassouilletRepository $grassouilletRepository): Response
    {
        // Set the session with attributes
        if ($session->get('arrayImagimot') === null && empty($session->get('arrayImagimot'))) {
            $arrayImagimot = $grassouilletRepository->findAll();
            shuffle($arrayImagimot);
            $session->set('arrayImagimot', $arrayImagimot);
        }
        if ($session->get('attemptsImagimot') === null && empty($session->get('attemptsImagimot'))) {
            $session->set('attemptsImagimot', 1);
        }

        // If the attempts are equal to the array length, redirect to the index of Imagimot
        if (count($session->get('arrayImagimot')) === $session->get('attemptsImagimot')) {
            return $this->redirectToRoute('app_imagimot');
        }

        $form = $this->createForm(ImagimotType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $animal = $form->get('animal')->getData();
            $entity = $session->get('arrayImagimot')[$session->get('attemptsImagimot') - 1];

            if (strtoupper($animal) === strtoupper($entity->getName())) {
                $attempt = $session->get('attemptsImagimot');
                $attempt++;
                $session->set('attemptsImagimot', $attempt);
            }

            return $this->redirectToRoute('app_imagimot_game');
        }

        return $this->render('grassouillet/form.html.twig', [
            'title' => 'Imagimot - Form',
            'animal' => $session->get('arrayImagimot')[$session->get('attemptsImagimot') - 1],
            'imagimotForm' => $form,
        ]);
    }
}
