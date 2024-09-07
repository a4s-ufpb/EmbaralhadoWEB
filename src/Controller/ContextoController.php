<?php

namespace App\Controller;

use App\Entity\Contexto;
use App\Entity\Palavra;
use App\Form\ContextoType;
use App\Form\PalavraType;
use App\Repository\ContextoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contexto')]
class ContextoController extends AbstractController
{
    #[Route(name: 'app_contexto_index', methods: ['GET'])]
    public function index(ContextoRepository $contextoRepository): Response
    {
        return $this->render('contexto/index.html.twig', [
            'contextos' => $contextoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contexto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contexto = new Contexto();
        $form = $this->createForm(ContextoType::class, $contexto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contexto);
            $entityManager->flush();

            return $this->redirectToRoute('app_contexto_index');
        }

        return $this->render('contexto/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_contexto_show', methods: ['GET', 'POST'])]
    public function show(Contexto $contexto, Request $request, EntityManagerInterface $entityManager): Response
    {
        $palavra = new Palavra();
        $palavra->setContexto($contexto);
        $form = $this->createForm(PalavraType::class, $palavra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($palavra);
            $entityManager->flush();
            return $this->redirectToRoute('app_contexto_show', ['id' => $contexto->getId()]);
        }

        return $this->render('contexto/show.html.twig', [
            'contexto' => $contexto,
            'palavras' => $contexto->getPalavras(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contexto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contexto $contexto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContextoType::class, $contexto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contexto_index');
        }

        return $this->render('contexto/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_contexto_delete', methods: ['POST'])]
    public function delete(Request $request, Contexto $contexto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contexto->getId(), $request->request->get('_token'))) {
            // O cascade remove garante que todas as palavras associadas sejam excluídas
            $entityManager->remove($contexto);
            $entityManager->flush();
        }

        // Redireciona para a mesma página após excluir
        return $this->redirect($request->headers->get('referer'));
    }


}
