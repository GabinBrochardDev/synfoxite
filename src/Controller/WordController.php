<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WordController extends AbstractController
{
    private $correctWords = [
        'word1' => 'guirlande',
        'word2' => 'or',
        'word3' => 'manille',
        'word4' => 'grassouillet'
    ];   
    #[Route('/check-word', name: 'check_word')]

     
    public function checkWord(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $inputId = $data['inputId'];
        $userInput = $data['userInput'];

        $correctWord = $this->correctWords[$inputId] ?? null;

        if ($correctWord === $userInput) {
            return new JsonResponse(['valid' => true]);
        } else {
            return new JsonResponse(['valid' => false]);
        }
    }
}
