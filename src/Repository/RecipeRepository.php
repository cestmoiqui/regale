<?php

namespace App\Repository;

use App\Data\RecipeSearchData;
use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * Retrieve recipes from the database based on search criteria
     *@return Recipe[]
     */
    public function findSearch(RecipeSearchData $recipeSearchData): array
    {
        $query = $this
            ->createQueryBuilder('r')
            ->select('c', 'r')
            ->join('r.recipeCategories', 'c')
            ->leftJoin('r.tags', 'tag');

        // Filter by category
        if (!empty($recipeSearchData->categories)) {
            $categoryIds = array_map(function ($category) {
                return $category->getId(); // Suppose que l'entité Category a une méthode getId()
            }, $recipeSearchData->categories);

            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $categoryIds);
        }

        // Filter by tags
        if (!empty($recipeSearchData->tags)) {
            $tagIds = array_map(function ($tag) {
                return $tag->getId(); // Suppose que l'entité Tag a une méthode getId()
            }, $recipeSearchData->tags);

            $query = $query
                ->andWhere('tag.id IN (:tags)')
                ->setParameter('tags', $tagIds);
        }


        // Sorting
        if (!empty($recipeSearchData->sort)) {
            switch ($recipeSearchData->sort) {
                case 'best':
                    $query = $query->orderBy('a.rating', 'DESC'); // Assuming you have a "rating" field in your Recipe entity
                    break;
                case 'oldest':
                    $query = $query->orderBy('a.createdAt', 'ASC'); // Assuming you have a "createdAt" datetime field in your Recipe entity
                    break;
                case 'latest':
                    $query = $query->orderBy('a.createdAt', 'DESC');
                    break;
            }
        }

        // Search by recipe name or content
        if (!empty($recipeSearchData->q)) {
            $query = $query
                ->andWhere('a.title LIKE :q')
                ->setParameter('q', "%{$recipeSearchData->q}%");
        }

        return $query->getQuery()->getResult();
    }
}
