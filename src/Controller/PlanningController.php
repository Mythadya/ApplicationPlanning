<?php

// src/Controller/PlanningController.php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JourFerieRepository;
use App\Util\DateHelper;


class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(
        FormationRepository $formationRepo,
        JourFerieRepository $jourFerieRepo
    ): Response {
         $dateDebut = new \DateTime('first day of this month');
         $dateFin = new \DateTime('last day of next month');

         $formations = $formationRepo->findAll();
         $joursFeries = $jourFerieRepo->findAll();

         $joursFeriesArray = array_map(fn($j) => $j->getDate()->format('Y-m-d'), $joursFeries);
         $semaines = DateHelper::getWeeksBetween($dateDebut, $dateFin);

         return $this->render('planning/index.html.twig', [
             'formations' => $formations,
             'semaines' => $semaines,
             'joursFeries' => $joursFeriesArray
        ]);
    }
}
