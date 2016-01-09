<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContributorRepository")
 * @ORM\Table(name="contributor",indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 */
class Contributor
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserGoogle")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;
    /**
     * @ORM\Column(type="integer")
     */
    protected $status;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $contributionDate;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    
    public function getUser()
    {
        return $this->user;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * Set contributor status.
     *
     * @param int $status
     *
     * @return int
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get contributor status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set contribution date.
     *
     * @param string $contributionDate
     *
     * @return datetime
     */
    public function setContributionDate($contributionDate)
    {
        $this->contributionDate = $contributionDate;

        return $this;
    }

    /**
     * Get contribution date.
     *
     * @return datetime
     */
    public function getContributionDate()
    {
        return $this->contributionDate;
    }
}
