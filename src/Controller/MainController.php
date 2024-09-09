<?php

namespace App\Controller;

use App\Repository\ContextoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/home.html.twig');
    }

    #[Route('/jogo/{id}', name: 'app_jogo_contexto', methods: ['GET'])]
    public function startGameWithContext(ContextoRepository $contextoRepository, int $id): Response
    {
        // Encontra o contexto pelo ID
        $contexto = $contextoRepository->find($id);

        if (!$contexto) {
            throw $this->createNotFoundException('Contexto não encontrado');
        }

        // Lógica do jogo para embaralhar palavras
        $palavras = $contexto->getPalavras()->toArray();

        // Transformar o array de objetos Palavra em um array de strings (somente a palavra)
        $palavrasString = array_map(fn($palavra) => $palavra->getPalavra(), $palavras);

        // Dump para verificar o array de palavras antes de embaralhar
        dump($palavrasString);

        // Embaralhar as palavras
        shuffle($palavrasString);

        // Dump para verificar o array de palavras após embaralhar
        dump($palavrasString);

        // Seleciona até 5 palavras (se existirem)
        $selectedWords = array_slice($palavrasString, 0, 5);

        // Passando o contextoId para o template do jogo
        return $this->render('game/game.html.twig', [
            'words' => $selectedWords,
            'contextoId' => $id, // Passa o id do contexto para o template
        ]);
    }
}
