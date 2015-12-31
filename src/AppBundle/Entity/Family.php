<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FamilyRepository")
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
     *  @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */

    protected $endDate;
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
     * Set description.
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getdescription()
    {
        return $this->description;
    }


    /**
     * Set picto_url.
     *
     * @param string $picto_url
     *
     * @return Project
     */
    public function setPictoUrl($picto_url)
    {
        $this->picto_url = $picto_url;

        return $this;
    }

    /**
     * Get picto_url.
     *
     * @return string
     */
    public function getPictoUrl()
    {
        return $this->picto_url;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Project
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
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

    /**
     * @Assert\Callback
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    public function isActive()
    {
        return $this->active;
    }

}
