<?php

namespace App\Controller;

use App\Entity\ArticleCategory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleCategoryController extends AbstractController
{
    #[Route('/article/category/{slug}', name: 'article_category_show')]
    public function show(?ArticleCategory $articleCategory): Response
    {
        if (!$articleCategory) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('article_category/show.html.twig', [
            'aricleCategory' => $articleCategory,
        ]);
    }
}
