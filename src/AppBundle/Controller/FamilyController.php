<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Base\BaseController;
use AppBundle\Entity\Family;
use AppBundle\Entity\Project;
use AppBundle\Form\Type\FamilyType;
use Symfony\Component\HttpFoundation\Request;

class FamilyController extends BaseController
{
    /**
     * @Template()
     */
    public function displayTableAction()
    {
        $user = $this->getUser();

        $families =  $this->getDoctrine()->getRepository("AppBundle:Family")->listActiveFamilies();
        $inactive_families =  $this->getDoctrine()->getRepository("AppBundle:Family")->listInactiveFamilies();

        $family = new Family();
        $family->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * project::MAX_DURATION)));
        $form   = $this->createForm(new FamilyType(), $family);

        return array(
            'families'          => $families,
            'inactive_families' => $inactive_families,
            'user'              => $user,
            'form'              => $form->createView(),
        );
    }

    /**
     * @Route("/family/publish", name="familyPublish")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function publishFamilyAction(Request $request)
    {
        $family = new Family();
        // Max 90 days - defaut 90 days
        $family->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * Project::MAX_DURATION)));
        $form   = $this->createForm(new FamilyType(), $family);
        $form->handleRequest($request);
        $user   = $this->getUser();

        if ($form->isValid()) {
            $family->setUser($user);
            $family->setActive(true);
            $family->setPictoUrl('');
            $manager = $this->get("doctrine")->getManager();
            $manager->persist($family);
            $manager->flush();

            $this->success("Your family have been published.");

            return $this->redirectToRoute('homepage');
        }

        return [
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
        ];
    }
}
