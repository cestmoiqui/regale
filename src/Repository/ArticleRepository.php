<?php

namespace App\Repository;

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
    public function findSearch(): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $queryBuilder
            ->select('a')
            ->orderBy('a.createdAt', 'DESC');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
