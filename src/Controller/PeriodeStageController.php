<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PeriodeStageController extends AbstractController
{
    #[Route('/periode/stage', name: 'app_periode_stage')]
    public function index(): Response
    {
        return $this->render('periode_stage/index.html.twig', [
            'controller_name' => 'PeriodeStageController',
        ]);
    }
}
