<?php

namespace FreakyOldNationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="FreakyOldNationBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \string
     * @ORM\Column(name="title", type="string", nullable=false, unique=false)
     */
    private $title;

    /**
     * @var \string
     * @ORM\Column(name="description", type="string", nullable=false, unique=false)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="date", type="string", nullable=false, unique=false)
     */
    private $date;

    /**
     * @var integer
     * @ORM\Column(name="status", type="integer", nullable=false, unique=false)
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_creation", type="datetime", nullable=false, unique=false)
     */
    private $dateCreation;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="FreakyOldNationBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $user;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->status = 0;
        $this->dateCreation = new \DateTime();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return Event
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Event
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}

