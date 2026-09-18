<?php

namespace App\Repository;

use App\Entity\Book;
use App\Search\BookSearchCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function search(BookSearchCriteria $criteria): array
    {
        $qb = $this->createQueryBuilder('b');

        // Author join — needed for the author filter OR for sorting by author
        if ($criteria->author) {
            $qb->innerJoin('b.authors', 'a');
        }

        if ($criteria->q) {
            $qb->andWhere('b.title LIKE :q')->setParameter('q', "%{$criteria->q}%");
        }
        if ($criteria->author) {
            $qb->andWhere('a.name LIKE :author')->setParameter('author', "%{$criteria->author}%");
        }

        if ($criteria->available) {
            $qb->andWhere('b.available = true');
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
