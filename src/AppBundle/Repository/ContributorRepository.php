<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\UserGoogle;
use AppBundle\Entity\Project;

class ContributorRepository extends EntityRepository
{
    public function findByUserAndProject(UserGoogle $user, Project $project)
    {
        $data = $this->_em->createQuery("
            SELECT c
            FROM AppBundle\Entity\Contributor c
            WHERE c.user = :user
            AND c.project = :project
        ")->setParameters(array(
            'user'    => $user,
            'project' => $project,
        ))->execute();

        return $data ? reset($data) : $data;
    }
}
