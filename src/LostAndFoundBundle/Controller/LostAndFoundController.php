<?php

namespace LostAndFoundBundle\Controller;

use LostAndFoundBundle\Entity\LostAndFound;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lostandfound controller.
 *
 * @Route("lostandfound")
 */
class LostAndFoundController extends Controller
{
    /**
     * Lists all lostAndFound entities.
     *
     * @Route("/", name="lostandfound_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lostAndFounds = $em->getRepository(LostAndFound::class)->findAll();

        $data=$this -> get('jms_serializer')->serialize($lostAndFounds,'json');
        $res= new Response($data);

        return($res);

        // return $this->render('lostandfound/index.html.twig', array(
        //     'lostAndFounds' => $lostAndFounds,
        // ));
    }

    /**
     * Creates a new lostAndFound entity.
     *
     * @Route("/new", name="lostandfound_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        // $lostAndFound = new Lostandfound();
        // $form = $this->createForm('LostAndFoundBundle\Form\LostAndFoundType', $lostAndFound);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($lostAndFound);
        //     $em->flush();

        //     return $this->redirectToRoute('lostandfound_show', array('id' => $lostAndFound->getId()));
        // }

        // return $this->render('lostandfound/new.html.twig', array(
        //     'lostAndFound' => $lostAndFound,
        //     'form' => $form->createView(),
        // ));
        $data=$request->getContent();
        //deserialize data: création d'un objet 'livre' à partir des données json envoyées
        $lostAndFound=$this->get('jms_serializer')->deserialize($data,'LostAndFoundBundle\Entity\LostAndFound','json');
        //ajout dans la base
        $em=$this->getDoctrine()->getManager();
        
        $em->persist($lostAndFound);
        $em->flush();
        return new Response('livre ajouté avec succès');



    }

    /**
     * Finds and displays a lostAndFound entity.
     *
     * @Route("/{id}", name="lostandfound_show")
     * @Method("GET")
     */
    public function showAction(LostAndFound $lostAndFound)
    {
        $deleteForm = $this->createDeleteForm($lostAndFound);

        return $this->render('lostandfound/show.html.twig', array(
            'lostAndFound' => $lostAndFound,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lostAndFound entity.
     *
     * @Route("/{id}/edit", name="lostandfound_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LostAndFound $lostAndFound)
    {
        $deleteForm = $this->createDeleteForm($lostAndFound);
        $editForm = $this->createForm('LostAndFoundBundle\Form\LostAndFoundType', $lostAndFound);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lostandfound_edit', array('id' => $lostAndFound->getId()));
        }

        return $this->render('lostandfound/edit.html.twig', array(
            'lostAndFound' => $lostAndFound,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lostAndFound entity.
     *
     * @Route("/{id}", name="lostandfound_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LostAndFound $lostAndFound)
    {
        $form = $this->createDeleteForm($lostAndFound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lostAndFound);
            $em->flush();
        }

        return $this->redirectToRoute('lostandfound_index');
    }

    /**
     * Creates a form to delete a lostAndFound entity.
     *
     * @param LostAndFound $lostAndFound The lostAndFound entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LostAndFound $lostAndFound)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lostandfound_delete', array('id' => $lostAndFound->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
