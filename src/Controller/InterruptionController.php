<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterruptionController extends AbstractController
{
    #[Route('/interruption', name: 'app_interruption')]
    public function index(): Response
    {
        return $this->render('interruption/index.html.twig', [
            'controller_name' => 'InterruptionController',
        ]);
    }
}
