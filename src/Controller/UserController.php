<?php

namespace App\Controller;

use App\Entity\User;
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
}
