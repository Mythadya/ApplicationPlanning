<?php

// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
    // Si l'utilisateur est déjà connecté, on le redirige ailleurs (par ex. homepage)
    if ($this->getUser()) {
        return $this->redirectToRoute('profil');  // adapte le nom de la route si besoin
    }

    // obtenir les erreurs de connexion s’il y en a
    $error = $authenticationUtils->getLastAuthenticationError();

    // dernier nom d’utilisateur entré par l’utilisateur
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
  }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // cette méthode peut rester vide - elle est interceptée par le système de sécurité
    }
}
