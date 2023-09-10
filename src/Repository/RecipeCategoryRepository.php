<?php

namespace App\Repository;

use App\Entity\RecipeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeCategory>
 *
 * @method RecipeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeCategory[]    findAll()
 * @method RecipeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeCategory::class);
    }

    public function countArticlesByCategory(RecipeCategory $category)
    {
        return $this->createQueryBuilder('c')
            ->select('count(a.id)')
            ->join('c.recipe', 'a')
            ->where('c.id = :categoryId')
            ->setParameter('categoryId', $category->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
