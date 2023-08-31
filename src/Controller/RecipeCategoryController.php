<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeCategoryController extends AbstractController
{
    #[Route('/recipe/category', name: 'app_recipe_category')]
    public function index(): Response
    {
        return $this->render('recipe_category/index.html.twig', [
            'controller_name' => 'RecipeCategoryController',
        ]);
    }
}
