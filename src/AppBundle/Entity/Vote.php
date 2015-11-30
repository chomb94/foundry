<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 * @ORM\Table(
 *     name="vote",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="vote_idx", columns={"user_id", "project_id"})}
 * )
 */
class Vote
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
}
