<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 08/08/2017
 * Time: 10:56
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RedditPostRepository extends EntityRepository
{
    public function myOwnQuery($id)
    {
        return $this->getEntityManager()->createQuery(
            "
            SELECT p, a
            FROM AppBundle\Entity\RedditPost p
            JOIN p.author a
            WHERE p.id > :id
            ORDER BY a.name DESC
            "
        )->setParameter('id', $id)
            ->getResult();
    }
}