<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Project {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;
    /**
     * @ORM\Column(type="string", length=400)
     */
    protected $short_description;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $team; // Who?
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $full_description; // Why? What? How?
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $video_url;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $risks_challenges;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $delivery_promise;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endDate;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imageName;
     /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="project_image", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $imageFile;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set short_description
     *
     * @param string $short_description
     * @return Project
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * Get short_description
     *
     * @return string 
     */
    public function getShortdescription()
    {
        return $this->short_description;
    }
    
    /**
     * Set team
     *
     * @param string $team
     * @return Project
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return string 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set full_description
     *
     * @param string $full_description
     * @return Project
     */
    public function setFullDescription($full_description)
    {
        $this->full_description = $full_description;

        return $this;
    }

    /**
     * Get full_description
     *
     * @return string 
     */
    public function getFullDescription()
    {
        return $this->full_description;
    }

    /**
     * Set video_url
     *
     * @param string $video_url
     * @return Project
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;

        return $this;
    }

    /**
     * Get video_url
     *
     * @return string 
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * Set risks_challenges
     *
     * @param string $risks_challenges
     * @return Project
     */
    public function setRisksChallenges($risks_challenges)
    {
        $this->risks_challenges = $risks_challenges;

        return $this;
    }

    /**
     * Get risks_challenges
     *
     * @return string 
     */
    public function getRisksChallenges()
    {
        return $this->risks_challenges;
    }
    
    /**
     * Set delivery_promise
     *
     * @param string $delivery_promise
     * @return Project
     */
    public function setDeliveryPromise($delivery_promise)
    {
        $this->delivery_promise = $delivery_promise;

        return $this;
    }

    /**
     * Get delivery_promise
     *
     * @return string 
     */
    public function getDeliveryPromise()
    {
        return $this->delivery_promise;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Project
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Project
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Project
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \endDate 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Project
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageFile
     *
     * @param string $imageFile
     * @return Project
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get imageFile
     *
     * @return File 
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }
}
