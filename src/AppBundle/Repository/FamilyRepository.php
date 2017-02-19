<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Family;

/**
 * FamilyRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FamilyRepository extends EntityRepository
{
    public function listActiveFamilies($active=1)
    {
        $dql = "SELECT f as family, count(p.id) as nbProjects
                FROM AppBundle:Family f
                LEFT JOIN AppBundle:Project p
                WITH p.family = f.id
                WHERE f.active = :active
                    AND p.active = 1
                GROUP BY f.name
                ORDER BY f.name
        ";

        return $this->_em
              ->createQuery($dql)
              ->setParameters([
                'active' => $active,
            ])->getResult();
    }

    public function deleteFamily(Family $family)
    {
        $this->_em
           ->createQuery("
            UPDATE AppBundle\Entity\Project p
            SET p.family = NULL
            WHERE p.family = :family
        ")->setParameters([
            'family' => $family,
        ])->execute();

        $this->_em->remove($family);
        $this->_em->flush();
    }
}
