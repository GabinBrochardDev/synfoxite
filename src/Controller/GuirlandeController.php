<?php

namespace App\Controller;

use App\Entity\Guirlande;
use App\Repository\GuirlandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class GuirlandeController extends AbstractController
{
    #[Route('/motcroises/{id}/submit', name: 'motcroises_submit', methods: ['POST'])]
    public function submitWord(Request $request, Guirlande $guirlande, GuirlandeRepository $guirlandeRepository): Response
    {
        $word = $request->request->get('word');

        if ($guirlande->canFormWord($word)) {
            $guirlande->addFoundWord($word);
            $guirlandeRepository->save($guirlande, true);
        } else {
            $this->addFlash('error', 'Le mot ne peut pas être formé avec les lettres disponibles !');
        }
        
        return $this->redirectToRoute('guirlande_index', ['id' => $guirlande->getId()]);

    }
}
