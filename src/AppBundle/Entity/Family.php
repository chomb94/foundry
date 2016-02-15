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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $max_votes;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $slack_channel;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $slack_nickname;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $publish_votes = false;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    protected $countProjects = 0;

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
     * Set max_votes.
     *
     * @param string $max_votes
     *
     * @return int
     */
    public function setMaxVotes($max_votes)
    {
        $this->max_votes = $max_votes;

        return $this;
    }

    /**
     * Get max_votes.
     *
     * @return int
     */
    public function getMaxVotes()
    {
        return $this->max_votes;
    }

    /**
     * Set slack_channel.
     *
     * @param string $slack_channel
     *
     * @return Family
     */
    public function setSlackChannel($slack_channel)
    {
        $this->slack_channel = $slack_channel;

        return $this;
    }

    /**
     * Get slack_channel.
     *
     * @return string
     */
    public function getSlackChannel()
    {
        $return_channel = $this->slack_channel;
        if ($return_channel != "") {
            if ($return_channel[0] != '#' and $return_channel[0] != '@') {
                $return_channel = "#".$return_channel;
            }
        }
        return $return_channel;
    }

    /**
     * Set slack_nickname.
     *
     * @param string $slack_nickname
     *
     * @return Family
     */
    public function setSlackNickname($slack_nickname)
    {
        $this->slack_nickname = $slack_nickname;

        return $this;
    }

    /**
     * Get slack_nickname.
     *
     * @return string
     */
    public function GetSlackNickname()
    {
        return $this->slack_nickname;
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

    /**
     * Set publish_votes.
     *
     * @param string $publish_votes
     *
     * @return int
     */
    public function setPublishVotes($publish_votes)
    {
        $this->publish_votes = $publish_votes;
    }

    /**
     * Get publish_votes.
     *
     * @return int
     */
    public function getPublishVotes()
    {
        return $this->publish_votes;
    }



    public function setCountProjects($countProjects)
    {
        $this->countProjects = $countProjects;
        return $this;
    }

    public function getCountProjects()
    {
        return $this->countProjects;
    }

}
