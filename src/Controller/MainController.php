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

    #[\Symfony\Component\Routing\Annotation\Route('/game', name: 'app_game')]
    public function startGame(): Response
    {
        // Localiza o arquivo JSON na pasta public/json
        $jsonPath = $this->getParameter('kernel.project_dir') . '/public/json/words.json';

        // Verifica se o arquivo JSON existe
        if (!file_exists($jsonPath)) {
            throw $this->createNotFoundException('Arquivo JSON não encontrado.');
        }

        // Carrega o conteúdo do arquivo JSON
        $jsonContent = file_get_contents($jsonPath);

        // Decodifica o conteúdo do JSON
        $jsonData = json_decode($jsonContent, true);

        // Verifica se houve erro ao decodificar o JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erro ao decodificar o JSON: ' . json_last_error_msg());
        }

        // Verifica se há pelo menos 10 palavras
        if (count($jsonData['words']) < 10) {
            throw new \Exception('O arquivo JSON deve conter pelo menos 10 palavras.');
        }

        // Seleciona 10 palavras aleatórias
        $randomKeys = array_rand($jsonData['words'], 10);
        $randomWords = array_map(function ($key) use ($jsonData) {
            return $jsonData['words'][$key];
        }, $randomKeys);

        // Passa as 10 palavras aleatórias para o template
        return $this->render('game/game.html.twig', [
            'words' => $randomWords
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
