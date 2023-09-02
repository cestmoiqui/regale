<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Article;
use App\Repository\MediaRepository;
use App\Repository\RecipeRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecipeCategoryRepository;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, ArticleRepository $articleRepo, MediaRepository $mediaRepo, ArticleCategoryRepository $articleCategoryRepo, RecipeRepository $recipeRepo, RecipeCategoryRepository $recipeCategoryRepo): Response
    {
        // Use the EntityManager to retrieve the last item created
        $article = $entityManager->getRepository(Article::class)
            // sorting items by date of creation ('createdAt') in descending order
            ->findOneBy([], ['createdAt' => 'DESC']);

        $articleCategory = null;
        $mediaArticle = null;

        if ($article !== null) {
            // Get categories related to the article
            $articleCategory = $article->getArticleCategories();
            // Use MediaRepository to find media associated with the current article
            $mediaArticle = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);
        }


        // Use the EntityManager to retrieve the last item created
        $recipe = $entityManager->getRepository(Recipe::class)
            // sorting items by date of creation ('createdAt') in descending order
            ->findOneBy([], ['createdAt' => 'DESC']);

        $recipeCategory = null;
        $mediaRecipe = null;

        if ($recipe !== null) {
            // Get categories related to the recipes
            $recipeCategory = $recipe->getRecipeCategories();
            // Use MediaRepository to find media associated with the current recipe
            $mediaRecipe = $mediaRepo->findOneBy(['mediaOwnerId' => $recipe->getId()]);
        }

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepo->findAll(),
            'mediaArticle' => $mediaArticle,
            'articleCategories' => $articleCategoryRepo->findAll(),
            'articleCategory' => $articleCategory,
            'article' => $article,
            'isAllArticlesPage' => false,
            'recipe' => $recipeRepo->findAll(),
            'mediaRecipe' => $mediaRecipe,
            'recipeCategories' => $recipeCategoryRepo->findAll(),
            'recipeCategory' => $recipeCategory,
            'recipe' => $recipe,
        ]);
    }
}
