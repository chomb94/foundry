<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Project;

class ProjectRepository extends EntityRepository
{
    public function delete(Project $project) {
        $this->_em->createQuery("
            DELETE AppBundle\Entity\Step s
            WHERE s.project_id = :id
         ")->setParameters(array(
             'id' => $project->getId(),
         ))->execute();

        // BAD but there's a ManyToOne here.... need to fix it to manage deleted projects
        $this->_em->createQuery("
            DELETE AppBundle\Entity\CreditsHistory c
            WHERE c.project = :project
         ")->setParameters(array(
             'project' => $project,
         ))->execute();

        $this->_em->createQuery("
            DELETE AppBundle\Entity\Project p
            WHERE p.id = :id
         ")->setParameters(array(
             'id' => $project->getId(),
         ))->execute();
    }
}
