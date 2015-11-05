<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;

class SearchController extends BaseController
{
    /**
     * @Route("/search", name="search")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$user     = $this->getUser();
        $search   = $request->get("s");
/*
        $data = $this->_em->createQuery("
            SELECT ur
            FROM Blablacar\Entity\Main\Rating\Rating ur
            WHERE (
                ur.ratedUser = :rater_id
                AND ur.ratingUser = :rated_id
                OR ur.ratedUser = :rated_id
                AND ur.ratingUser = :rater_id
            )
            AND ur.status != :deleted
            AND (ur.ratingType = :two_way OR (ur.ratingType = :simple AND ur.moderationFlag <> :refused))
        ")->setParameters(array(
               'rater_id' => $rater->getId(),
               'rated_id' => $rated->getId(),
               'deleted'  => Rating::STATUS_DELETED,
               'two_way'  => Rating::RATING_TWO_WAY,
               'simple'   => Rating::RATING_SIMPLE,
               'refused'  => Rating::MODERATION_FLAG_REFUSED,
           ))->getResult();
*/
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->findByUser($user);

        foreach ($projects as $oneProject) {
            $step_list   = $this->get("doctrine")->getRepository("AppBundle:Step")->findBy(['project_id' => $oneProject->getId()]);
            $all_credits = $this->get("doctrine")->getRepository("AppBundle:CreditsHistory")->findBy(['project' => $oneProject]);
            $oneProject->setStepsAndCredits($step_list, $all_credits);
        }

        return [
            'projects'        => $projects,
            'user'            => $user,
        ];
    }
}
