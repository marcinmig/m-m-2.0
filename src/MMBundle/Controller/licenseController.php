<?php

namespace MMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MMBundle\Entity\license;
use MMBundle\Form\licenseType;

/**
 * license controller.
 *
 * @Route("/license")
 */
class licenseController extends Controller
{
    /**
     * Lists all license entities.
     *
     * @Route("/", name="license_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $licenses = $em->getRepository('MMBundle:license')->findAll();

        return $this->render('license/index.html.twig', array(
            'licenses' => $licenses,
        ));
    }

    /**
     * Creates a new license entity.
     *
     * @Route("/new", name="license_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $license = new license();
        $form = $this->createForm(new licenseType(), $license);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($license);
            $em->flush();

            return $this->redirectToRoute('license_show', array('id' => $license->getId()));
        }

        return $this->render('license/new.html.twig', array(
            'license' => $license,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a license entity.
     *
     * @Route("/{id}", name="license_show")
     * @Method("GET")
     */
    public function showAction(license $license)
    {
        $deleteForm = $this->createDeleteForm($license);

        return $this->render('license/show.html.twig', array(
            'license' => $license,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing license entity.
     *
     * @Route("/{id}/edit", name="license_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, license $license)
    {
        $deleteForm = $this->createDeleteForm($license);
        $editForm = $this->createForm(new licenseType(), $license);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($license);
            $em->flush();

            return $this->redirectToRoute('license_edit', array('id' => $license->getId()));
        }

        return $this->render('license/edit.html.twig', array(
            'license' => $license,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a license entity.
     *
     * @Route("/{id}", name="license_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, license $license)
    {
        $form = $this->createDeleteForm($license);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($license);
            $em->flush();
        }

        return $this->redirectToRoute('license_index');
    }

    /**
     * Creates a form to delete a license entity.
     *
     * @param license $license The license entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(license $license)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('license_delete', array('id' => $license->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
