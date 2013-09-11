<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\Orm\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        return $this->getRecentQuery()->getResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRecentQueryBuilder()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.createdAt', 'DESC');
    }

    public function getRecentQuery()
    {
        return $this->getRecentQueryBuilder()->getQuery();
    }

    public function getRecent($max=3)
    {
        return $this->getRecentQuery()
                ->setMaxResults($max)
                ->getResult();
    }

    /**
     * Get just the most recent post
     */
    public function getRecentPost()
    {
        return $this->getRecentQuery()
                ->setMaxResults(1)
                ->getSingleResult();
    }
}