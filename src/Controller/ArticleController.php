<?php

namespace App\Controller;

use App\Data\ArticleSearchData;
use App\Form\ArticleSearchForm;
use App\Repository\MediaRepository;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
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
    public function all(MediaRepository $mediaRepo, ArticleCategoryRepository $articleCategoryRepo, ArticleRepository $articleRepo, Request $request): Response
    {
        $articleData = new ArticleSearchData();
        $articleForm = $this->createForm(ArticleSearchForm::class, $articleData);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            if ($this->isEmptySearch($articleData)) {
                $articles = $articleRepo->findBy([], ['createdAt' => 'DESC']);
            } else {
                $articles = $articleRepo->findSearch($articleData);
            }
        } else {
            $articles = $articleRepo->findBy([], ['createdAt' => 'DESC']);
        }

        $mediaForArticles = [];
        $categoriesForArticles = [];
        foreach ($articles as $article) {
            $media = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);
            $mediaForArticles[$article->getId()] = $media;

            $categoriesForArticles[$article->getId()] = $article->getArticleCategories();
        }

        return $this->render('article/all.html.twig', [
            'articles' => $articles,
            'articleForm' => $articleForm->createView(), // Assurez-vous d'utiliser createView() pour passer le formulaire à Twig.
            'mediaForArticles' => $mediaForArticles,
            'categoriesForArticles' => $categoriesForArticles,
            'articleCategories' => $articleCategoryRepo->findAll(),
            'isAllArticlesPage' => true,
        ]);
    }

    /**
     * Check if the search criteria is empty.
     *
     * @param ArticleSearchData $data
     * @return bool
     */
    private function isEmptySearch(ArticleSearchData $data): bool
    {
        // Vérifiez si la recherche par texte est vide
        $isQEmpty = empty(trim($data->q));

        // Vérifiez si le tri est vide
        $isSortEmpty = empty(trim($data->sort));

        // Vérifiez si les tableaux de catégories et de tags sont vides
        $areCategoriesEmpty = empty($data->categories);
        $areTagsEmpty = empty($data->tags);

        // Si tout est vide, alors la recherche est considérée comme vide
        return $isQEmpty && $isSortEmpty && $areCategoriesEmpty && $areTagsEmpty;
    }
}
