<?php

namespace App\Controller;

use App\Entity\JourFerie;
use App\Form\JourFerieType;
use App\Repository\JourFerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jours-feries')]
class JourFerieController extends AbstractController
{
    #[Route('/', name: 'jours_feries_index', methods: ['GET'])]
    public function index(JourFerieRepository $repository): Response
    {
        $joursFeries = $repository->findAll();

        return $this->render('jour_ferie/index.html.twig', [
            'joursFeries' => $joursFeries,
        ]);
    }

    #[Route('/new', name: 'jours_feries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $jourFerie = new JourFerie();
        $form = $this->createForm(JourFerieType::class, $jourFerie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($jourFerie);
            $em->flush();

            $this->addFlash('success', 'Jour férié ajouté avec succès.');

            return $this->redirectToRoute('jours_feries_index');
        }

        return $this->render('jour_ferie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'jours_feries_edit', methods: ['GET', 'POST'])]
    public function edit(JourFerie $jourFerie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(JourFerieType::class, $jourFerie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Jour férié mis à jour.');

            return $this->redirectToRoute('jours_feries_index');
        }

        return $this->render('jour_ferie/edit.html.twig', [
            'form' => $form->createView(),
            'jourFerie' => $jourFerie,
        ]);
    }

    #[Route('/{id}/delete', name: 'jours_feries_delete', methods: ['POST'])]
    public function delete(Request $request, JourFerie $jourFerie, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jourFerie->getId(), $request->request->get('_token'))) {
            $em->remove($jourFerie);
            $em->flush();

            $this->addFlash('success', 'Jour férié supprimé.');
        }

        return $this->redirectToRoute('jours_feries_index');
    }
}
