<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\MediaRepository;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, ArticleRepository $articleRepo, MediaRepository $mediaRepo, CategoryRepository $categoryRepo): Response
    {
        // Use the EntityManager to retrieve the last item created
        $article = $entityManager->getRepository(Article::class)
            // sorting items by date of creation ('createdAt') in descending order
            ->findOneBy([], ['createdAt' => 'DESC']);

        // Use MediaRepository to find media associated with the current article
        $media = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);

        // Get categories related to the article
        if ($article !== null) {
            $articleCategories = $article->getCategories();
        }

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepo->findAll(),
            'media' => $media,
            'categories' => $categoryRepo->findAll(),
            'articleCategories' => $articleCategories,
            'article' => $article,
            'isAllArticlesPage' => false,
        ]);
    }
}
