<?php

namespace App\Controller;

use App\Entity\Interruption;
use App\Form\InterruptionType;
use App\Repository\InterruptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterruptionController extends AbstractController
{
    #[Route('/interruptions', name: 'interruptions_list', methods: ['GET'])]
    public function index(InterruptionRepository $repo): Response
    {
        return $this->render('interruption/index.html.twig', [
            'interruptions' => $repo->findAll(),
        ]);
    }

    #[Route('/interruption/new', name: 'interruption_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $interruption = new Interruption();
        $form = $this->createForm(InterruptionType::class, $interruption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($interruption);
            $em->flush();

            $this->addFlash('success', 'Interruption ajoutée.');
            return $this->redirectToRoute('interruptions_list');
        }

        return $this->render('interruption/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/interruption/{id}/edit', name: 'interruption_edit', methods: ['GET', 'POST'])]
    public function edit(Interruption $interruption, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(InterruptionType::class, $interruption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Interruption mise à jour.');
            return $this->redirectToRoute('interruptions_list');
        }

        return $this->render('interruption/edit.html.twig', [
            'form' => $form->createView(),
            'interruption' => $interruption,
        ]);
    }

    #[Route('/interruption/{id}/delete', name: 'interruption_delete', methods: ['POST'])]
    public function delete(Request $request, Interruption $interruption, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interruption->getId(), $request->request->get('_token'))) {
            $em->remove($interruption);
            $em->flush();
            $this->addFlash('success', 'Interruption supprimée.');
        }

        return $this->redirectToRoute('interruptions_list');
    }
}
