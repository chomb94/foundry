<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project",indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @Vich\Uploadable
 */
class Project
{
    const MAX_DURATION = 90; // maximum time a project can gather money

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    /**
     *  @ORM\Column(type="text")
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
    protected $published = false;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @see validateEndDate
     */
    protected $endDate;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $imageName;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserGoogle")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Family")
     * @ORM\JoinColumn(name="family_id", referencedColumnName="id")
     */
    protected $family;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = true;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    protected $allSteps;
    protected $allCredits;
    protected $countStepInProgress = false;
    protected $countStepCompleted = false;
    protected $countStepToComplete = false;
    protected $countUpdates = 0;
    protected $countMessages = 0;

    /**
     * @Vich\UploadableField(mapping="project_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

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
     * Set Family.
     *
     * @param Family $family
     *
     * @return Project
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family.
     *
     * @return Family
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set Category.
     *
     * @param Category $category
     *
     * @return Project
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set short_description.
     *
     * @param string $short_description
     *
     * @return Project
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * Get short_description.
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->short_description;
    }

    /**
     * Set team.
     *
     * @param string $team
     *
     * @return Project
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team.
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set full_description.
     *
     * @param string $full_description
     *
     * @return Project
     */
    public function setFullDescription($full_description)
    {
        $this->full_description = $full_description;

        return $this;
    }

    /**
     * Get full_description.
     *
     * @return string
     */
    public function getFullDescription()
    {
        return $this->full_description;
    }

    /**
     * Set video_url.
     *
     * @param string $video_url
     *
     * @return Project
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;

        return $this;
    }

    /**
     * Get video_url.
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * Set risks_challenges.
     *
     * @param string $risks_challenges
     *
     * @return Project
     */
    public function setRisksChallenges($risks_challenges)
    {
        $this->risks_challenges = $risks_challenges;

        return $this;
    }

    /**
     * Get risks_challenges.
     *
     * @return string
     */
    public function getRisksChallenges()
    {
        return $this->risks_challenges;
    }

    /**
     * Set delivery_promise.
     *
     * @param string $delivery_promise
     *
     * @return Project
     */
    public function setDeliveryPromise($delivery_promise)
    {
        $this->delivery_promise = $delivery_promise;

        return $this;
    }

    /**
     * Get delivery_promise.
     *
     * @return string
     */
    public function getDeliveryPromise()
    {
        return $this->delivery_promise;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return Project
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Project
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * Set imageName.
     *
     * @param string $imageName
     *
     * @return Project
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName.
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageFile.
     *
     * @param string $imageFile
     *
     * @return Project
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Get imageFile.
     *
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getSteps()
    {
        return $this->allSteps;
    }

    public function getCredits()
    {
        return $this->allCredits;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;
    
        return $this;
    }

    public function getParticipants()
    {
        return $this->participants;
    }

    public function setStepsWithStatus($allSteps)
    {
        $this->allSteps = $allSteps;
        foreach ($allSteps as $oneStep) {
            $status = $oneStep->getStatus();
            if ($status == 100) {
                $oneStep->setisCompleted(true);
                $this->setCountStepCompleted(true);
            } elseif ( $status < 100 and $status > 0 ) {
                $oneStep->setisInProgress(true);
                $this->setCountStepInProgress(true);
            } else {
                $this->setCountStepToComplete(true);                
            }
        }
    }


    public function setCountStepCompleted($countStepCompleted)
    {
        $this->countStepCompleted = $countStepCompleted;
        return $this;
    }

    public function setCountStepInProgress($countStepInProgress)
    {
        $this->countStepInProgress = $countStepInProgress;
        return $this;
    }

    public function setCountStepToComplete($countStepToComplete)
    {
        $this->countStepToComplete = $countStepToComplete;
        return $this;
    }

    public function setCountMessages($countMessages)
    {
        $this->countMessages = $countMessages;
        return $this;
    }

    public function setCountUpdates($countUpdates)
    {
        $this->countUpdates = $countUpdates;
        return $this;
    }

    public function getCountStepCompleted()
    {
        return $this->countStepCompleted;
    }

    public function getCountStepInProgress()
    {
        return $this->countStepInProgress;
    }

    public function getCountStepToComplete()
    {
        return $this->countStepToComplete;
    }

    public function getCountMessages()
    {
        return $this->countMessages;
    }

    public function getCountUpdates()
    {
        return $this->countUpdates;
    }

    public function getDaysToGo()
    {
        $endDate = $this->getEndDate()->getTimestamp();
        $now = time();
        $diff = (integer) (($endDate - $now) / (60 * 60 * 24));

        return $diff;
    }

    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @Assert\Callback
     */
    public function validateEndDate(ExecutionContextInterface $context)
    {
        $tm = $this->getEndDate()->getTimestamp();
        if ($tm <= time()) {
            $context
               ->buildViolation('You should choose a date in the future')
               ->atPath('endDate')
               ->addViolation()
            ;
        }
        /* Remove 90 days constraint
        if ($tm > time() + 60 * 60 * 24 * self::MAX_DURATION) {
            $context
               ->buildViolation(sprintf("The end date can't be greater than %d days.", self::MAX_DURATION))
               ->atPath('endDate')
               ->addViolation()
            ;
        }
        */
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function isActive()
    {
        return $this->getDaysToGo() >= 0 && $this->active;
    }

}
