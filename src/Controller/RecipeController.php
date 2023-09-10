<?php

namespace App\Controller;

use App\Entity\Article;
use App\Data\RecipeSearchData;
use App\Form\RecipeSearchForm;
use App\Repository\MediaRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecipeCategoryRepository;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recipe/{slug}', name: 'recipe_show')] // Displays a unique recipe based on a unique identifier for each recipe (slug)
    public function show(): Response
    {
        return $this->render('recipe/show.html.twig', []);
    }

    #[Route('/recipes', name: 'recipe_all')] // Displays all recipes
    public function all(EntityManagerInterface $entityManager, MediaRepository $mediaRepo, ArticleCategoryRepository $articleCategoryRepo, RecipeRepository $recipeRepo, RecipeCategoryRepository $recipeCategoryRepo, Request $request): Response
    {
        $recipeData = new RecipeSearchData();
        $recipeForm = $this->createForm(RecipeSearchForm::class, $recipeData);
        $recipeForm->handleRequest($request);

        if ($recipeForm->isSubmitted() && $recipeForm->isValid()) {
            if ($this->isEmptySearch($recipeData)) {
                $recipes = $recipeRepo->findBy([], ['createdAt' => 'DESC']);
            } else {
                $recipes = $recipeRepo->findSearch($recipeData);
            }
        } else {
            $recipes = $recipeRepo->findBy([], ['createdAt' => 'DESC']);
        }

        $mediaForRecipes = [];
        $categoriesForRecipes = [];
        foreach ($recipes as $recipe) {
            $media = $mediaRepo->findOneBy(['mediaOwnerId' => $recipe->getId()]);
            $mediaForRecipes[$recipe->getId()] = $media;

            $categoriesForRecipes[$recipe->getId()] = $recipe->getRecipeCategories();
        }

        // Use the EntityManager to retrieve the last item created
        $article = $entityManager->getRepository(Article::class)
            // sorting items by date of creation ('createdAt') in descending order
            ->findOneBy([], ['createdAt' => 'DESC']);

        $articleCategory = null;
        $mediaArticle = null;

        if ($article !== null) {
            // Get categories related to the articles
            $articleCategory = $article->getArticleCategories();
            // Use MediaRepository to find media associated with the current article
            $mediaArticle = $mediaRepo->findOneBy(['mediaOwnerId' => $article->getId()]);
        }

        return $this->render('recipe/all.html.twig', [
            'recipes' => $recipes,
            'recipeForm' => $recipeForm,
            'mediaForRecipes' => $mediaForRecipes,
            'categoriesForRecipes' => $categoriesForRecipes,
            'recipeCategories' => $recipeCategoryRepo->findAll(),
            'isAllRecipesPage' => true,
            'articleCategories' => $articleCategoryRepo->findAll(),
        ]);
    }

    /**
     * Check if the search criteria is empty.
     *
     * @param RecipeSearchData $data
     * @return bool
     */
    private function isEmptySearch(RecipeSearchData $data): bool
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
