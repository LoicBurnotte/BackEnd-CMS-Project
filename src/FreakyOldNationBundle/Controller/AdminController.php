<?php

namespace FreakyOldNationBundle\Controller;

use FreakyOldNationBundle\Entity\Event;
use FreakyOldNationBundle\Entity\File;
use FreakyOldNationBundle\Form\EventType;
use FreakyOldNationBundle\Form\FileType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    # --------------------------------------  FILES  ----------------------------------------------

//* @Security("has_role('ROLE_USER')")
//    /**
//     * @param Request $request
//     * @Route(name="createfile", path="/admin/files")
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function createFileAction(Request $request)
//    {
//        $tm = $this->get("lexik_jwt_authentication.jwt_manager");
//        $token = $tm->create($this->getUser());
////      $this->get("security.token_storage")->getToken()->getUser();
////      $this->getUser();      fait exactement la même chose que la ligne ci-dessus!!
//        $file = new File();
//        $form = $this->createForm(FileType::class, $file);
//        $form->handleRequest($request);
//
//
//
////        $storeFolder = $this->getParameter("files_directory"); //
//
//        if ($form->isSubmitted() && $form->isValid()){
//            $user = $this->get('security.token_storage')->getToken()->getUser();
//            $file->setUser($user);
//            $mime = "image";
////            $mime = $file->guessExtension();
//            $file->setMimeType($mime);
//
////            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
//
////            $file = $request->files->get ( 'file' );
////            $fileName = md5 ( uniqid () ); // . '.' . $file->guessExtension ()
////            dump($file);
////            $original_name = $file->getClientOriginalName ();
////            dump($original_name);
////            $file->move ( $this->container->getParameter ( 'files_directory' ), $fileName );
////            $file_entity = new File ();
////            $file_entity->setFileName ( $fileName );
////            $file_entity->setActualName ( $original_name );
//
////
////            $filename = $file->getFile();
////            $uniquePath = md5(uniqid()).$filename->getClientOriginalName();
////            $file->move($this->getParameter("files_directory"), $uniquePath);
//
//
//            // moves the file to the directory where brochures are stored
////            $file->move(
////                $this->getParameter('brochures_directory'),
////                $uniquePath
////            );
//
//
////            $filename = $file->getFile();
////            $uniquePath = md5(uniqid()).$filename->getClientOriginalName();
////            $file->move($this->getParameter("files_directory"), $uniquePath);
////
//
////            $status = 1;
////            $file->setStatus($status);
////            $filename = $file->getFile();
////            $uniquePath = md5(uniqid()).$filename->getClientOriginalName();
////            $file->move($this->getParameter("files_directory"), $uniquePath);
////            $file->setPath($uniquePath);
////
////            //Récupération de l'image avatar
////            $filename = md5(uniqid()) . $file->getFile()->getClientOriginalName();
////            $file->getFile()->move(
////                $this->getParameter("files_directory"),
////                $filename
////            );
////            $file->setFile($filename);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($file);
//            $em->flush();
//            return $this->redirectToRoute("read");
//        }
//        return $this->render("@FreakyOldNation/admin/createfile.html.twig", [
//            "form" => $form->createView(),
//            "token" => $token
//        ]);
//    }

    /**
     * @Route(name="editfile", path="/admin/editfile/{fileID}", requirements={"page"="\d+"})
     * @param Request $request
     * @param $fileID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editFileAction(Request $request, $fileID)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('FreakyOldNationBundle:Event')->find($fileID);
        dump($fileID);
        if($file == null){
            throw $this->createNotFoundException('Fichier non trouvé!');
        }
        $form = $this->createForm(EventType::class, $file);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($file);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render('@FreakyOldNation/admin/editfile.html.twig', array(
            'form' => $form->createView(),
            'fileID' => $fileID
        ));
    }

    /**
     * @Route(name="deletefile", path="/admin/delete/{fileID}", requirements={"page"="\d+"})
     * @param $fileID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteFileAction($fileID)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('FreakyOldNationBundle:File')->find($fileID);
        $em->remove($file);
        if($file === null){
            throw $this->createNotFoundException('Fichier non trouvé!');
        }
        $em->flush();
        return $this->redirectToRoute('read');
    }

    # --------------------------------------  EVENTS  ----------------------------------------------
    /**
     * @Route(name="createevent", path="/admin/createevent")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $event->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render('@FreakyOldNation/admin/createevent.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(name="editevent", path="/admin/edit/{eventID}", requirements={"page"="\d+"})
     * @param Request $request
     * @param $eventID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editEventAction(Request $request,$eventID)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('FreakyOldNationBundle:Event')->find($eventID);
        if($event === null){
            throw $this->createNotFoundException('Evènement non trouvé!');
        }
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render('@FreakyOldNation/admin/editevent.html.twig', array(
            'form' => $form->createView(),
            'eventID' => $eventID
        ));
    }

    /**
     * @Route(name="deleteevent", path="/admin/delete/{eventID}", requirements={"page"="\d+"})
     * @param $eventID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteEventAction($eventID)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('FreakyOldNationBundle:Event')->find($eventID);
        $em->remove($event);
        if($event === null){
            throw $this->createNotFoundException('Evènement non trouvé!');
        }
        $em->flush();
        return $this->redirectToRoute('read');
    }


    # --------------------------------------  READ ALL  ----------------------------------------------

    /**
     * @Route(name="read",path="/admin/read")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction()
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('FreakyOldNationBundle:File')->findAll();
        $events = $em->getRepository('FreakyOldNationBundle:Event')->findAll();
        return $this->render('@FreakyOldNation/admin/read.html.twig', [
            'events' => $events,
            'files' => $files
        ]);
    }
}
