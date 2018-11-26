<?php

namespace FreakyOldNationBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route(name="home", path="/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render("@FreakyOldNation/public/home.html.twig");
    }

    /**
     * @Route(name="notfound", path="/notfound")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notfoundAction()
    {
        return $this->render("@FreakyOldNation/public/notfound.html.twig");
    }
}
