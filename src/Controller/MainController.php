<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [

        ]);
    }

    #[Route('/game', name: 'app_game')]
    public function startGame(): Response
    {
        // Carregar o conteúdo do JSON (substitua o caminho conforme necessário)
        $jsonFilePath = $this->getParameter('kernel.project_dir') . '/public/json/words.json';

        // Verifica se o arquivo JSON existe
        if (!file_exists($jsonFilePath)) {
            throw $this->createNotFoundException('Arquivo JSON não encontrado.');
        }

        // Lê o conteúdo do JSON
        $jsonContent = file_get_contents($jsonFilePath);
        $jsonData = json_decode($jsonContent, true);  // Decodificar JSON para array associativo

        // Obter as palavras do JSON
        $allWords = $jsonData['words'];

        // Randomizar palavras (exemplo com 3 palavras aleatórias)
        shuffle($allWords); // Embaralha o array
        $selectedWords = array_slice($allWords, 0, 3); // Seleciona as 3 primeiras palavras após embaralhar

        // Passa os dados das palavras randomizadas para o template
        return $this->render('game/game.html.twig', [
            'words' => $selectedWords
        ]);
    }

    #[Route('/context', name: 'app_contextChoice')]
    public function context(): Response
    {
        return $this->render('context/contextChoice.html.twig');
    }

    #[Route('/list', name: 'app_pointList')]
    public function pointList(): Response
    {
        return $this->render('list/pointList.html.twig');
    }
}
