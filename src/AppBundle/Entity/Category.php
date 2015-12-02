<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $family_id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $picto_url;


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
     * Set family_id.
     *
     * @param string $family_id
     *
     * @return int
     */
    public function setFamilyId($family_id)
    {
        $this->family_id = $family_id;

        return $this;
    }

    /**
     * Get family_id.
     *
     * @return int
     */
    public function getFamilyId()
    {
        return $this->family_id;
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
