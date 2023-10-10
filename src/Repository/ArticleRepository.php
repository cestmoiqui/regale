<?php

namespace App\Repository;

use App\Data\ArticleSearchData;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Retrieve articles from the database based on search criteria
     *@return Article[]
     */
    public function findSearch(ArticleSearchData $articleSearchData): array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            ->join('a.articleCategories', 'c')
            ->leftJoin('a.tags', 'tag');

        // Filter by category
        if (!empty($articleSearchData->categories)) {
            $categoryIds = array_map(function ($category) {
                return $category->getId(); // Assumes Category entity has a getId() method
            }, $articleSearchData->categories);

            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $categoryIds);
        }

        // Filter by tags
        if (!empty($articleSearchData->tags)) {
            $tagIds = array_map(function ($tag) {
                return $tag->getId(); // Suppose que l'entité Tag a une méthode getId()
            }, $articleSearchData->tags);

            $query = $query
                ->andWhere('tag.id IN (:tags)')
                ->setParameter('tags', $tagIds);
        }


        // Sorting
        if (!empty($articleSearchData->sort)) {
            switch ($articleSearchData->sort) {
                case 'best':
                    $query = $query->orderBy('a.rating', 'DESC'); // Assuming you have a "rating" field in your Article entity
                    break;
                case 'oldest':
                    $query = $query->orderBy('a.createdAt', 'ASC'); // Assuming you have a "createdAt" datetime field in your Article entity
                    break;
                case 'latest':
                    $query = $query->orderBy('a.createdAt', 'DESC');
                    break;
            }
        }

        // Search by article name or content
        if (!empty($articleSearchData->q)) {
            $query = $query
                ->andWhere('a.title LIKE :q')
                ->setParameter('q', "%{$articleSearchData->q}%");
        }

        return $query->getQuery()->getResult();
    }
}
