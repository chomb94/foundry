<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\UserGoogle;
use AppBundle\Entity\Project;

class VoteRepository extends EntityRepository
{
    public function findByUserAndProject(UserGoogle $user, Project $project)
    {
        $data = $this->_em->createQuery("
            SELECT v
            FROM AppBundle\Entity\Vote v
            WHERE v.user = :user
            AND v.project = :project
        ")->setParameters(array(
            'user'    => $user,
            'project' => $project,
        ))->execute();

        return $data ? reset($data) : $data;
    }
}
