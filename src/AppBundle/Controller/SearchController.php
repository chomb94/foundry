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

        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->search($search);

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
