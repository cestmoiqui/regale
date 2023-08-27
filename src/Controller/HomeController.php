<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\MediaRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, ArticleRepository $articleRepo, MediaRepository $mediaRepo): Response
    {
        $article = $entityManager->getRepository(Article::class)
            ->findOneBy([], ['createdAt' => 'DESC']);

        $media = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepo->findAll(),
            'media' => $media,
        ]);
    }
}
