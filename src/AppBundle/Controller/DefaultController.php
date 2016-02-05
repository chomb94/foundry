<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Base\BaseController;


class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        // First list with only project before end date
        $dql = "SELECT p as project,
                    (SELECT count(u.id) FROM AppBundle:ProjectUpdate u WHERE p.id = u.project) as cnt_updates,
                    (SELECT count(m.id) FROM AppBundle:ProjectMessage m WHERE p.id = m.project) as cnt_messages
                FROM AppBundle:Project p
                WHERE p.endDate >= :endDate
                ORDER BY p.creationDate DESC
                ";

        $projects_result = $this
            ->get("doctrine")
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameter("endDate", date("Y-m-d H:i:s", time()))
            ->setMaxResults(12)
            ->getResult();

        $projects = array();
        foreach ($projects_result as $oneProject_array) {
            //\Symfony\Component\VarDumper\VarDumper::dump($oneProject_array);die();
            $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($oneProject_array['project']);
            $oneProject_array['project']->setParticipants($participants);
            $oneProject_array['project']->setCountUpdates($oneProject_array['cnt_updates']);
            $oneProject_array['project']->setCountMessages($oneProject_array['cnt_messages']);
            array_push($projects, $oneProject_array['project']);
        }

        // Old projects (date < now)
        $dql_old = "SELECT p as project,
                        (SELECT count(u.id) FROM AppBundle:ProjectUpdate u WHERE p.id = u.project) as cnt_updates,
                        (SELECT count(m.id) FROM AppBundle:ProjectMessage m WHERE p.id = m.project) as cnt_messages
                    FROM AppBundle:Project p
                    WHERE p.endDate < :endDate
                    ORDER BY p.creationDate DESC
                    ";
        $old_projects_result = $this
            ->get("doctrine")
            ->getEntityManager()
            ->createQuery($dql_old)
            ->setParameter("endDate", date("Y-m-d H:i:s", time()))
            ->setMaxResults(12)
            ->getResult();

        $old_projects = array();
        foreach ($old_projects_result as $oneProject_array) {
            //\Symfony\Component\VarDumper\VarDumper::dump($oneProject_array);die();
            $participants = $this->get("doctrine")->getRepository("AppBundle:Project")->participants($oneProject_array['project']);
            $oneProject_array['project']->setParticipants($participants);
            $oneProject_array['project']->setCountUpdates($oneProject_array['cnt_updates']);
            $oneProject_array['project']->setCountMessages($oneProject_array['cnt_messages']);
            array_push($old_projects, $oneProject_array['project']);
        }
        return array(
            'menu_hp' => 'active',
            'projects' => $projects,
            'old_projects' => $old_projects,
        );
    }
}
