<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name:'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [

        ]);
    }

    #[Route('/game', name: 'app_game')]
    public function startGame(): Response
    {
        $jsonData = [
            'word' => 'cavalo',
            'image' => '/images/homeImage.webp'
        ];

        // Renderizando a view e passando o JSON
        return $this->render('game/game.html.twig', [
            'jsonData' => $jsonData
        ]);
        //return $this->render('game/game.html.twig');
    }
}
