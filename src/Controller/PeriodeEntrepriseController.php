<?php

namespace App\Controller;

use App\Entity\PeriodeEntreprise;
use App\Form\PeriodeEntrepriseType;
use App\Repository\PeriodeEntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/periode-entreprise')]
class PeriodeEntrepriseController extends AbstractController
{
    #[Route('/', name: 'periode_entreprise_index', methods: ['GET'])]
    public function index(PeriodeEntrepriseRepository $repo): Response
    {
        return $this->render('periode_entreprise/index.html.twig', [
            'periodes' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'periode_entreprise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $periode = new PeriodeEntreprise();
        $form = $this->createForm(PeriodeEntrepriseType::class, $periode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $periode->setCreatedAt(new \DateTime());
            $em->persist($periode);
            $em->flush();

            $this->addFlash('success', 'Période en entreprise créée.');
            return $this->redirectToRoute('periode_entreprise_index');
        }

        return $this->render('periode_entreprise/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'periode_entreprise_edit', methods: ['GET', 'POST'])]
    public function edit(PeriodeEntreprise $periode, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(PeriodeEntrepriseType::class, $periode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Période mise à jour.');
            return $this->redirectToRoute('periode_entreprise_index');
        }

        return $this->render('periode_entreprise/edit.html.twig', [
            'form' => $form->createView(),
            'periode' => $periode,
        ]);
    }

    #[Route('/{id}/delete', name: 'periode_entreprise_delete', methods: ['POST'])]
    public function delete(Request $request, PeriodeEntreprise $periode, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $periode->getId(), $request->request->get('_token'))) {
            $em->remove($periode);
            $em->flush();
            $this->addFlash('success', 'Période supprimée.');
        }

        return $this->redirectToRoute('periode_entreprise_index');
    }
}
