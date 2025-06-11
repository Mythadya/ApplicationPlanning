<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/formations', name: 'formations_list', methods: ['GET'])]
    public function index(FormationRepository $repo): Response
    {
        $formations = $repo->findAll();

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('/formation/new', name: 'formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($formation);
            $em->flush();

            $this->addFlash('success', 'Formation créée avec succès.');

            return $this->redirectToRoute('formations_list');
        }

        return $this->render('formation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/formation/{id}/edit', name: 'formation_edit', methods: ['GET', 'POST'])]
    public function edit(Formation $formation, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Formation mise à jour.');

            return $this->redirectToRoute('formations_list');
        }

        return $this->render('formation/edit.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation,
        ]);
    }

    #[Route('/formation/{id}/delete', name: 'formation_delete', methods: ['POST'])]
    public function delete(Request $request, Formation $formation, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $em->remove($formation);
            $em->flush();

            $this->addFlash('success', 'Formation supprimée.');
        }

        return $this->redirectToRoute('formations_list');
    }
}
