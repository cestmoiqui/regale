<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')] // Displays a unique article based on a unique identifier for each article (slug)
    public function show(): Response
    {
        return $this->render('article/show.html.twig', []);
    }

    #[Route('/articles', name: 'article_all')] // Displays all articles
    public function all(EntityManagerInterface $entityManager, MediaRepository $mediaRepo, ArticleCategoryRepository $categoryRepo): Response
    {
        // Use Doctrine to retrieve all articles from the database
        $articles = $entityManager->getRepository(Article::class)->findAll();

        // Initialize an array to store the media associated with each item
        $mediaForArticles = [];
        // Initialize an array to store the categories associated with each item
        $categoriesForArticles = [];

        // Loop over each item to retrieve the associated media and categories
        foreach ($articles as $article) {
            // Use MediaRepository to find media associated with the current article
            $media = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);
            // Store media in array using item ID as key
            $mediaForArticles[$article->getId()] = $media;

            // Store categories in array using item ID as key
            $categoriesForArticles[$article->getId()] = $article->getArticleCategories();
        }

        return $this->render('article/all.html.twig', [
            'articles' => $articles,
            'mediaForArticles' => $mediaForArticles,
            'categoriesForArticles' => $categoriesForArticles, // Nouveau tableau contenant les catégories
            'categories' => $categoryRepo->findAll(),
            'isAllArticlesPage' => true,
        ]);
    }
}
