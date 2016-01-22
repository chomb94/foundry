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
     * @Route("/search/family/{familyName}", name="familySearch")
     * @Template()
     */
    public function familyAction(Request $request, $familyName)
    {
        $user     = $this->getUser();
        $familyName = trim($familyName);
        $family_array = $this->get("doctrine")->getRepository("AppBundle:Project")->familySearchFromName($familyName);
        $familyId = $family_array[0]->getId();
        $family = $this->get("doctrine")->getRepository("AppBundle:Family")->find($familyId);
        $projects_array = array();

        if (strlen($familyName) > 0) {
            $projects_result = $this->get("doctrine")->getRepository("AppBundle:Project")->projectSearchFromFamily($familyName);
            //\Symfony\Component\VarDumper\VarDumper::dump($projects_result);die();
        }
        
        foreach ($projects_result as $oneProject_array) {
            //\Symfony\Component\VarDumper\VarDumper::dump($oneProject_array);die();
            $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($oneProject_array['project']);
            $oneProject_array['project']->setParticipants($participants);
            $oneProject_array['project']->setCountUpdates($oneProject_array['cnt_updates']);
            $oneProject_array['project']->setCountMessages($oneProject_array['cnt_messages']);
            array_push($projects_array, $oneProject_array['project']);
        }

        return [
            'family'          => $family,
            'projects'        => $projects_array,
            'user'            => $user,
        ];
    }
}
