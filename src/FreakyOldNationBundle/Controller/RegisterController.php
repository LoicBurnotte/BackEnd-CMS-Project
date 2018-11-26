<?php

namespace FreakyOldNationBundle\Controller;

use FreakyOldNationBundle\Entity\User;
use FreakyOldNationBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegisterController extends Controller
{
//    /**
//     * @Route(name="admin", path="/admin")
//     * @return Response
//     * @Security("has_role('ROLE_USER')")
//     */
//    public function loginGrantedAction()
//    {
//        $tm = $this->get("lexik_jwt_authentication.jwt_manager");
//        $token = $tm->create($this->getUser());
////      $this->get("security.token_storage")->getToken()->getUser();
////      $this->getUser();      fait exactement la même chose que la ligne ci-dessus!!
//        return $this->render("@FreakyOldNation/admin/admin.html.twig", [
//            "token" => $token
//        ]);
//    }

    /**
     * @Route(name="login", path="/login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function loginAction(AuthenticationUtils $utils)
    {
        $username = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();
        return $this->render("@FreakyOldNation/admin/login.html.twig", [
            "username" => $username,
            "error" => $error
        ]);
    }

    /**
     * @Route(name="register", path="/admin/register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setRole(["ROLE_USER"]);
            $pwd = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pwd);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("login");
        }
        return $this->render("@FreakyOldNation/admin/register.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
