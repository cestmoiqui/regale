<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleCategoryController extends AbstractController
{
    #[Route('/article/category/{slug}', name: 'category_show')]
    public function show(?ArticleCategory $category): Response
    {
        if (!$category) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
