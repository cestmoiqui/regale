<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe/{slug}', name: 'recipe_show')]
    public function show(): Response
    {
        return $this->render('recipe/show.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
