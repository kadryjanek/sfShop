<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Category;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
    public function getProductsQuery(Category $category = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
            ->from('AppBundle:Product', 'p');

        if ($category) {
            $qb
                ->where('p.category = :category')
                ->setParameter('category', $category);
        }

        $qb->orderBy('p.name', 'DESC');

        return $qb->getQuery();
    }

    public function searchProductsQuery($data)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
            ->from('AppBundle:Product', 'p')
            ->where('p.name LIKE :query')
            ->orWhere('p.description LIKE :query')
            ->setParameter('query', '%'.$data.'%')
            ->orderBy('p.name', 'DESC');
        
        return $qb->getQuery();
    }

    public function getLastAdded()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
              ->from('AppBundle:Product', 'p')
              ->orderBy('p.id', 'DESC')
              ->setMaxResults(12);

        return $qb->getQuery()->getResult();
    }
}
