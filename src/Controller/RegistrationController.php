<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register/{email}', name: 'user_register')]
    public function register(
        string $email,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

        if (!$user || $user->getMotDePasse() !== null) {
            $this->addFlash('danger', 'Lien invalide ou utilisateur déjà inscrit.');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getMotDePasse());
            $user->setMotDePasse($hashedPassword);
            $user->setUpdatedAt(new \DateTime());

            $em->flush();

            $this->addFlash('success', 'Inscription réussie. Vous pouvez vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
