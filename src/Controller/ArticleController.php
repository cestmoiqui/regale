<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(): Response
    {
        return $this->render('article/show.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/articles', name: 'article_all')]
    public function all(): Response
    {
        return $this->render('article/all.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    public function recent(EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)
            ->findOneBy([], ['date' => 'DESC']);

        if (!$article) {
            return $this->redirectToRoute('home');  // Redirect to home page if no article found
        }

        return $this->render('article/_recent.html.twig', [
            'article' => $article,
        ]);
    } // The list method uses the EntityManager service to retrieve articles sorted by date in 'descending order', and then passes them to the articles/_recent.html.twig template.
}
