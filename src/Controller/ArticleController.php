<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Recipe;
use App\Data\ArticleSearchData;
use App\Form\ArticleSearchForm;
use App\Repository\MediaRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecipeCategoryRepository;
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
        return $this->render('article/show.html.twig', [
            'isAllRecipesPage' => true,
        ]);
    }

    #[Route('/articles', name: 'article_all')] // Displays all articles
    public function all(
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepo,
        ArticleCategoryRepository $articleCategoryRepo,
        ArticleRepository $articleRepo,
        RecipeCategoryRepository $recipeCategoryRepo,
        Request $request
    ): Response {
        $articleData = new ArticleSearchData();
        $articleForm = $this->createForm(ArticleSearchForm::class, $articleData);
        $articleForm->handleRequest($request);

        // Determine if a search was made and if valid, then fetch articles accordingly
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            if ($this->isEmptySearch($articleData)) {
                $articles = $articleRepo->findBy([], ['createdAt' => 'DESC']);
            } else {
                $articles = $articleRepo->findSearch($articleData);
            }
        } else {
            $articles = $articleRepo->findBy([], ['createdAt' => 'DESC']);
        }

        // Retrieve media and categories associated with each article
        $mediaForArticles = [];
        $categoriesForArticles = [];
        foreach ($articles as $article) {
            $media = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);
            $mediaForArticles[$article->getId()] = $media;

            $categoriesForArticles[$article->getId()] = $article->getArticleCategories();
        }

        // Retrieve the most recent recipe
        $recipe = $entityManager->getRepository(Recipe::class)->findOneBy([], ['createdAt' => 'DESC']);

        $recipeCategory = null;
        $mediaRecipe = null;

        if ($recipe !== null) {
            $recipeCategory = $recipe->getRecipeCategories();
            $mediaRecipe = $mediaRepo->findOneBy(['mediaOwnerId' => $recipe->getId()]);
        }

        $tags = $entityManager->getRepository(Tag::class)->findAll();

        return $this->render('article/all.html.twig', [
            'articles' => $articles,
            'articleForm' => $articleForm,
            'mediaForArticles' => $mediaForArticles,
            'categoriesForArticles' => $categoriesForArticles,
            'articleCategories' => $articleCategoryRepo->findAll(),
            'isAllArticlesPage' => true,
            'recipeCategories' => $recipeCategoryRepo->findAll(),
            'tags' => $tags
        ]);
    }

    /**
     * Determines if the search form is empty (no filters applied).
     *
     * @param ArticleSearchData $data
     * @return bool True if empty, otherwise false.
     */
    private function isEmptySearch(ArticleSearchData $data): bool
    {
        $isQEmpty = empty(trim($data->q));           // Check if the text search is empty
        $isSortEmpty = empty(trim($data->sort));     // Check if the sort option is empty
        $areCategoriesEmpty = empty($data->categories);  // Check if categories are empty
        $areTagsEmpty = empty($data->tags);          // Check if tags are empty

        return $isQEmpty && $isSortEmpty && $areCategoriesEmpty && $areTagsEmpty;
    }
}
