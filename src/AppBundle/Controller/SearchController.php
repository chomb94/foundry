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
        $search   = trim($request->get("s"));

        $projects = array();
        if (strlen($search) > 0) {
            $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->search($search);
        }

        return [
            'projects'        => $projects,
            'user'            => $user,
        ];
    }

    /**
     * @Route("/search/family/{familyId}/{familyName}", name="familySearch")
     * @Template()
     */
    public function familyAction(Request $request, $familyId, $familyName)
    {
        $user     = $this->getUser();
        $familyId = trim($familyId);
        $family = $this->get("doctrine")->getRepository("AppBundle:Family")->find($familyId);
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->projectSearchByFamilyId($familyId);

        foreach ($projects as $oneProject) {
            $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($oneProject);
            $oneProject->setParticipants($participants);
        }

        return [
            'family'          => $family,
            'projects'        => $projects,
            'user'            => $user,
        ];
    }
}
