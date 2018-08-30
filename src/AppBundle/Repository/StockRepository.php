<?php

namespace AppBundle\Repository;

/**
 * StockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLastStockOrderByDate()
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM AppBundle\Entity\Stock s
            WHERE s.type = :types
            AND s.etat = 1
            ORDER BY s.createdAt DESC
            '
        )->setParameter('types', [1]);

        // returns an array of Product objects
        return $query->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
