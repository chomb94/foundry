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

    public function search($searchString) {
        return $this->_em->createQuery("
            SELECT p
            FROM AppBundle\Entity\Project p
            LEFT JOIN AppBundle\Entity\Family f WITH p.family = f.id
            WHERE
                p.title LIKE :search
                OR p.short_description LIKE :search
                OR f.name LIKE :search
            ORDER BY p.active DESC, p.title ASC
         ")->setParameters(array(
             'search' => "%".$searchString."%",
         ))->getResult();
//            ORDER BY p.active DESC, TIMESTAMPDIFF(SECOND, p.endDate, NOW()) ASC
    }

    public function participants($project) {
        return $this->_em->createQuery("
            SELECT sum(c.nbCreditsSpent) as credits, ug.profilePicture as profilePicture, ug.username
            FROM AppBundle\Entity\CreditsHistory c
            LEFT JOIN AppBundle\Entity\UserGoogle ug
            WITH c.user_id = ug.id
            WHERE c.project = :project
            GROUP BY ug.id
         ")->setParameters(array(
             'project' => $project,
         ))->getResult();
    }

    public function projectSearchFromFamily($familyName) {
        return $this->_em->createQuery("
            SELECT p
            FROM AppBundle\Entity\Project p
            INNER JOIN AppBundle\Entity\Family f WITH p.family = f.id
            WHERE
                f.name = :search
            ORDER BY p.active DESC, p.title ASC
         ")->setParameters(array(
             'search' => $familyName,
         ))->getResult();
    }
//            ORDER BY p.active DESC, TIMESTAMPDIFF(SECOND, p.endDate, NOW()) ASC

    public function familySearchFromName($familyName) {
        return $this->_em->createQuery("
            SELECT f
            FROM AppBundle:Family f
            WHERE
                f.name = :search
         ")->setParameters(array(
             'search' => $familyName,
         ))->getResult();
    }
//            ORDER BY p.active DESC, TIMESTAMPDIFF(SECOND, p.endDate, NOW()) ASC
}
