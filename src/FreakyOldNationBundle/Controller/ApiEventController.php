<?php

namespace FreakyOldNationBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FreakyOldNationBundle\Entity\Event;
use FreakyOldNationBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiEventController extends Controller
{

//    / READ / EDIT / DELETE   ->    EVENTS :

    /**
     * @Rest\Get(path="/admin/event")
     * @Rest\View()
     *
     * @return Event[]|array
     */
    public function getAction()
    {
        return $this->getDoctrine()->getRepository(Event::class)->findAll();
    }

    /**
     * @param Request $request
     * @param Event $eventID
     * @Rest\Put(path="/admin/event/{eventID}")
     * @Rest\View()
     * @return Event|\Symfony\Component\Form\FormInterface
     */
    public function putAction(Request $request, Event $eventID)
    {
        $form = $this->createForm(EventType::class, $eventID, ["method" => "put"]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $eventID;
        }
        return $form;
    }

    /**
     * @param Event $eventID
     * @Rest\Get(path="/admin/event/{eventID}")
     * @Rest\View()
     * @return Event
     */
    public function getByIdAction(Event $eventID)
    {
        return $eventID;
    }

    /**
     * @param $eventID
     * @Rest\Delete(path="/admin/event/{eventID}")
     * @Rest\View()
     * @return Event|null|object
     */
    public function deleteAction($eventID)
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->find($eventID);
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $event;
    }

}
