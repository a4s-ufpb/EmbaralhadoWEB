<?php

namespace App\Controller;

use App\Entity\Palavra;
use App\Entity\Contexto; // Adicione isso
use App\Form\PalavraType;
use App\Repository\PalavraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/palavra')]
class PalavraController extends AbstractController
{
    #[Route(name: 'app_palavra_index', methods: ['GET'])]
    public function index(PalavraRepository $palavraRepository): Response
    {
        return $this->render('palavra/index.html.twig', [
            'palavras' => $palavraRepository->findAll(),
        ]);
    }

    #[Route('/new/{contexto}', name: 'app_palavra_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Contexto $contexto, EntityManagerInterface $entityManager): Response
    {
        $palavra = new Palavra();
        $palavra->setContexto($contexto); // Associa a palavra ao contexto
        $form = $this->createForm(PalavraType::class, $palavra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($palavra);
            $entityManager->flush();

            return $this->redirectToRoute('app_contexto_show', ['id' => $contexto->getId()]);
        }

        return $this->render('palavra/new.html.twig', [
            'palavra' => $palavra,
            'form' => $form->createView(),
            'contexto' => $contexto, // Passa o contexto para o template
        ]);
    }

    #[Route('/{id}', name: 'app_palavra_show', methods: ['GET'])]
    public function show(Palavra $palavra): Response
    {
        return $this->render('palavra/show.html.twig', [
            'palavra' => $palavra,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_palavra_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Palavra $palavra, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PalavraType::class, $palavra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_palavra_index');
        }

        return $this->render('palavra/edit.html.twig', [
            'palavra' => $palavra,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_palavra_delete', methods: ['POST'])]
    public function delete(Request $request, Palavra $palavra, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$palavra->getId(), $request->request->get('_token'))) {
            $entityManager->remove($palavra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_palavra_index');
    }
}
