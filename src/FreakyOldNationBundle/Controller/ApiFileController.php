<?php

namespace FreakyOldNationBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FreakyOldNationBundle\Entity\File;
use FreakyOldNationBundle\Form\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiFileController extends Controller
{

//    CREATE / READ / EDIT / DELETE   ->    FILES :

    /**
     * @Route(name="files", path="/admin")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function mainDisplayAction()
    {
        $tm = $this->get("lexik_jwt_authentication.jwt_manager");
        $token = $tm->create($this->getUser());
//        $file = new File();
//        $form = $this->createForm(FileType::class, $file);
//        $form->handleRequest($request);
        $form = $this->createForm(FileType::class);

        return $this->render("@FreakyOldNation/admin/createfile.html.twig", [
            "form" => $form->createView(),
            "token" => $token
        ]);
    }

//* @Route(name="createfile", "/admin")
    /**
     * @param Request $request
     * @Method({"GET", "POST"})
     * @Route(name="createfile", path="/admin")
     * @return JsonResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function ajaxSnippetImageSendAction(Request $request)
    {
        $em = $this->container->get("doctrine.orm.default_entity_manager");
        $file = new File();
        $media = $request->files->get('file');

        //[DATABASE] - FILE - user_id
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $file->setUser($user);
        //[DATABASE] - FILE - path
        $path = sha1(uniqid(mt_rand(), true));//.'.'.$file->getFile()->guessExtension());

//        dump($media->getFile()->guessExtension());
//        dump($file->getFile()->guessExtension());
//        die;
        //[DATABASE] - FILE - mime_type
//        $mimeType = $media->getFile()->guessExtension();
//        $file->setMimeType($mimeType);

        //[DATABASE] - FILE - name
        $file->setName($media->getClientOriginalName());

        $file->setFile($media);

//        $media->move($file->getUploadRootDir(), $path);
        $media->move($this->getParameter("files_directory"), $path);
        $file->setPath($media->getPathName());
//        $file->setPath($path);
        $file->upload();
        $em->persist($file);
        $em->flush();

        //infos sur le document envoyé
        //var_dump($request->files->get('file'));die;
        return new JsonResponse(array('success' => true));
    }
//        $file->setSize($file->getFile()->getClientSize());

    /**
     * @Rest\Get(path="/admin/file")
     * @Rest\View()
     *
     * @return File[]|array
     */
    public function getAction()
    {
        return $this->getDoctrine()->getRepository(File::class)->findAll();
    }

    /**
     * @param Request $request
     * @param File $fileID
     * @Rest\Put(path="/admin/file/{fileID}")
     * @Rest\View()
     * @return File|\Symfony\Component\Form\FormInterface
     */
    public function putAction(Request $request, File $fileID)
    {
        //dump(FileType::class);die;
        $form = $this->createForm(FileType::class, $fileID, ["method" => "put"]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $fileID;
        }
        return $form;
    }

    /**
     * @param File $fileID
     * @Rest\Get(path="/admin/file/{fileID}")
     * @Rest\View()
     * @return File
     */
    public function getByIdAction(File $fileID)
    {
        return $fileID;
    }

    /**
     * @Rest\Delete(path="/admin/file/{fileID}")
     * @Rest\View()
     */
    public function deleteAction($fileID)
    {
        $file = $this->getDoctrine()->getRepository(File::class)->find($fileID);
        $em = $this->getDoctrine()->getManager();
        $em->remove($file);
        $em->flush();
        return $file;
    }

}
