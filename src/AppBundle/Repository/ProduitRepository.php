<?php

namespace AppBundle\Repository;

/**
 * ProduitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param $price
     * @return Product[]
     */
    public function findAllQuantityIsNotNull(): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.quantite > :quantity')
            ->setParameter('quantity', 0 )
            ->orderBy('p.quantite', 'ASC')
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }

    public function countAllQuantityIsNotNull()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM AppBundle\Entity\Produit p
            WHERE p.quantite > 0'
        );

        // returns an array of Product objects
        return $query->execute();
    }

    public function findAllGreaterThanPrice($price)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM AppBundle\Entity\Produit p
            WHERE p.prix > :price
            ORDER BY p.price ASC'
        )->setParameter('price', $price);

        // returns an array of Product objects
        return $query->execute();
    }

    
}
