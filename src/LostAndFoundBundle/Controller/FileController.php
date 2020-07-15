<?php

namespace LostAndFoundBundle\Controller;

use LostAndFoundBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File controller.
 *
 * @Route("file")
 */
class FileController extends Controller
{
    /**
     * Lists all file entities.
     *
     * @Route("/", name="file_index")
     * @Method("GET")
     * @return JsonResponse
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository(File::class)->findAll();

        $data=$this->get('jms_serializer')->serialize($files,'json');
        $res= new Response($data);

        return($res);

        
        

        $response=array(

            'message'=>'images loaded with sucesss',
            'result' => json_decode($data)

        );

        return new JsonResponse($response,200);



        // return $this->render('file/index.html.twig', array(
        //     'files' => $files,
        // ));
    }

    /**
     * Creates a new file entity.
     *
     * @param Request $request
     *    @return JsonResponse
     * @Route("/new", name="file_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // $file = new File();
        // $form = $this->createForm('LostAndFoundBundle\Form\FileType', $file);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($file);
        //     $em->flush();

        //     return $this->redirectToRoute('file_show', array('id' => $file->getId()));
        // }

        // return $this->render('file/new.html.twig', array(
        //     'file' => $file,
        //     'form' => $form->createView(),
        // ));

        $em=$this->getDoctrine()->getManager();
        //$post = new Post();
        $file = new File();
        $uploadedImage=$request->files->get('file');
         /**
         * @var UploadedFile $image
         */


        $image=$uploadedImage;
        $imageName=md5(uniqid()).'.'.$image->guessExtension();
        $image->move($file->getUploadRootDir(),$imageName);
        $file->setImage($imageName);
        $file->setUpdateAt(new \DateTime());
        $file->setLabel($request->get('label'));
        $em=$this->getDoctrine()->getManager();
        $em->persist($file);
        $em->flush();

        $response=array(

            'code'=>0,
            'message'=>'File Uploaded with success!',
            'errors'=>null,
            'result'=>null

        );

        return new JsonResponse($response,Response::HTTP_CREATED);

        
    }

    /**
     * Finds and displays a file entity.
     *
     * @Route("/{id}", name="file_show" , requirements={"id":"\d+"})
     * 
     * @Method("GET")
     * @return JsonResponse
     */
    public function showAction( $id)
    {

        $imageName=$this->getDoctrine()->getRepository(File::class)->find($id)->getImage();
        


        $response=array(

            'code'=>0,
            'message'=>'get image with success!',
            'errors'=>null,
            'result'=>$imageName

        );

        return new JsonResponse($response,200);
        // $deleteForm = $this->createDeleteForm($file);

        // return $this->render('file/show.html.twig', array(
        //     'file' => $file,
        //     'delete_form' => $deleteForm->createView(),
        // ));
    }

    /**
     * Displays a form to edit an existing file entity.
     *
     * @Route("/{id}/edit", name="file_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, File $file)
    {
        $deleteForm = $this->createDeleteForm($file);
        $editForm = $this->createForm('LostAndFoundBundle\Form\FileType', $file);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_edit', array('id' => $file->getId()));
        }

        return $this->render('file/edit.html.twig', array(
            'file' => $file,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a file entity.
     *
     * @Route("/{id}", name="file_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, File $file)
    {
        $form = $this->createDeleteForm($file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }

        return $this->redirectToRoute('file_index');
    }

    /**
     * Creates a form to delete a file entity.
     *
     * @param File $file The file entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(File $file)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('file_delete', array('id' => $file->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
