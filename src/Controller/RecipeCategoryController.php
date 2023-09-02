<?php

namespace App\Controller;

use App\Entity\RecipeCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeCategoryController extends AbstractController
{
    #[Route('/recipe/category/{slug}', name: 'recipe_category_show')]
    public function index(?RecipeCategory $recipecategory): Response
    {
        if (!$recipecategory) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('recipe_category/show/index.html.twig', [
            'recipecategory' => $recipecategory,
        ]);
    }
}
