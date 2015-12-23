<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Family
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $picto_url;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $end_date;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserGoogle")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = true;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Family
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user.
     *
     * @param UserGoogle $user
     *
     * @return Project
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return UserGoogle
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function isActive()
    {
        return $this->active;
    }

}
