<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="credits_history",indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 */
class CreditsHistory {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $user_id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $nbCreditsSpent;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $pledgeDate;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

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
     * Set user_id
     *
     * @param string $user_id
     * @return integer
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    

    /**
     * Set number of spent credits
     *
     * @param int $credits
     * @return integer
     */
    public function setNbCreditsSpent($nbCreditsSpent)
    {
        $this->nbCreditsSpent = $nbCreditsSpent;

        return $this;
    }

    /**
     * Get how many credits spent
     *
     * @return integer 
     */
    public function getNbCreditsSpent()
    {
        return $this->nbCreditsSpent;
    }
    
    /**
     * Set pledge date
     *
     * @param string $pledgeDate
     * @return datetime
     */
    public function setPledgeDate($pledgeDate)
    {
        $this->pledgeDate = $pledgeDate;

        return $this;
    }

    /**
     * Get pledge date
     *
     * @return datetime 
     */
    public function getPledgeDate()
    {
        return $this->pledgeDate;
    }

    public function setProject(Project $project = null)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }

}
