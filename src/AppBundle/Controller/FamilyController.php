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
     * @Security("has_role('ROLE_USER')")
     */
    public function displayTableAction()
    {
        $user = $this->getUser();

        $families          = $this->getDoctrine()->getRepository("AppBundle:Family")->listActiveFamilies();
        $inactive_families = $this->getDoctrine()->getRepository("AppBundle:Family")->listInactiveFamilies();

        $family = new Family();
        $family->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * project::MAX_DURATION)));
        $form   = $this->createForm(new FamilyType(), $family);

        $forms = [];
        foreach (array($families, $inactive_families) as $family_group) {
            foreach ($family_group as $family) {
                $forms[$family['entity']->getId()] = $this
                   ->get('form.factory')
                   ->createNamedBuilder("family_form_".$family['entity']->getId(), FamilyType::class, $family['entity'], [])
                   ->getForm()
                   ->createView();
            }
        }

        return array(
            'families'          => $families,
            'inactive_families' => $inactive_families,
            'user'              => $user,
            'form'              => $form->createView(),
            'forms'             => $forms,
        );
    }

    /**
     * @Route("/family/publish/{id}", name="familyPublish", defaults={"id" = null})
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function publishFamilyAction(Request $request, $id)
    {
        $user       = $this->getUser();
        $repository = $this->getDoctrine()->getRepository("AppBundle:Family");
        if (is_null($id)) {
            $family = new Family();
            $family->setEndDate(new \DateTime(date("Y-m-d", time() + 60 * 60 * 24 * Project::MAX_DURATION)));
            $form   = $this->createForm(new FamilyType(), $family);
        } else {
            if (is_null($family = $repository->find($id))) {
                throw $this->createNotFoundException();
            }
            if ($family->getUser()->getId() !== $user->getId()) {
                throw $this->createAccessDeniedException();
            }
            $form = $this
               ->get('form.factory')
               ->createNamedBuilder("family_form_".$family->getId(), FamilyType::class, $family, [])
               ->getForm()
            ;
        }

        $form->handleRequest($request);

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
            'id'         => $id,
            'form'       => $form->createView(),
            'menu_start' => 'active',
            'user'       => $user,
        ];
    }

    /**
     * @Route("/enable-family-{id}-{enable}", name="enableFamily")
     * @Security("has_role('ROLE_USER')")
     */
    public function enableFamily($id, $enable)
    {
        $user       = $this->getUser();
        $repository = $this->getDoctrine()->getRepository("AppBundle:Family");
        $family     = $repository->find($id);

        if (is_null($family)) {
            throw $this->createNotFoundException();
        }

        if ($family->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        $family->setActive($enable);

        $em = $this->getDoctrine()->getManager();
        $em->persist($family);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/delete-family-{id}", name="familyDelete")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteFamily($id)
    {
        $user       = $this->getUser();
        $repository = $this->getDoctrine()->getRepository("AppBundle:Family");
        $family     = $repository->find($id);

        if (is_null($family)) {
            throw $this->createNotFoundException();
        }

        if ($family->getUser()->getId() !== $user->getId()) {
            throw $this->createAccessDeniedException();
        }

        $repository->deleteFamily($family);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/family/view-votes/{id}", name="familyVotes")
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function viewVotesAction(Request $request, $id)
    {
        $user       = $this->getUser();

        $family = $this->get("doctrine")->getRepository("AppBundle:Family")->find($id);
        $projects = $this->get("doctrine")->getRepository("AppBundle:Project")->projectByVotesFromFamily($id);

        if (!$family) {
            throw $this->createNotFoundException();
        }

        if ($family->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        return [
            'family'          => $family,
            'projects'        => $projects,
            'user'        => $user,
        ];
    }
}
