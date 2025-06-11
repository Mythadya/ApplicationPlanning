<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InviteUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    #[Route('/invite', name: 'user_invite')]
    public function invite(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new Utilisateur();
        $form = $this->createForm(InviteUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateInvitation(new \DateTime());
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());

            // Mot de passe temporaire NULL : complété à l’inscription
            $user->setMotDePasse(null);

            // Enregistre l'utilisateur
            $em->persist($user);
            $em->flush();

            // TODO : envoyer email ici

            $this->addFlash('success', 'Invitation envoyée à ' . $user->getEmail());

            return $this->redirectToRoute('user_invite');
        }

        return $this->render('invitation/invite.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
