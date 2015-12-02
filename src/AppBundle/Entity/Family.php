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
     * Set picto URL.
     *
     * @param string $picto_url
     *
     * @return Family
     */
    public function setPictoUrl($picto_url)
    {
        $this->picto_url = $picto_url;

        return $this;
    }

    /**
     * Get picto URL.
     *
     * @return string
     */
    public function getPictoUrl()
    {
        return $this->picto_url;
    }
}
