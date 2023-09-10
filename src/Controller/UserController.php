<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user/{username}', name: 'app_profile')]
    public function index(?User $user): Response
    {
        if (!$user) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user/{id}/promote", name="admin_user_promote")
     */
    public function promoteUser($id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $user->addRole('ROLE_ADMIN');
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_list'); // ou où vous voulez rediriger après
    }
}
