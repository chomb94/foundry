<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Step {
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    protected $project_id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;
    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $short_description;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDate;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;

    protected $isCompleted;
    protected $priceToFinish;
    protected $displayPledgeForm;

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
     * Set project_id
     *
     * @param string $project_id
     * @return integer
     */
    public function setProjectId($project_id)
    {
        $this->project_id = $project_id;

        return $this;
    }

    /**
     * Get project_id
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->project_id;
    }     

    /**
     * Set title
     *
     * @param string $title
     * @return Step
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
     * @return Step
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Step
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
     * @return Step
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
     * Set price
     *
     * @param string $price
     * @return integer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }     

    /**
     * Set if the step is already completed or not
     *
     * @param boolean $isCompleted
     * @return Step
     */
    public function setIsCompleted($isCompleted)
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }  

    /**
     * Get price
     *
     * @return boolean 
     */
    public function isCompleted()
    {
        return $this->isCompleted;
    }

    /**
     * Set price to finish the step
     *
     * @param string $priceToFinish
     * @return integer
     */
    public function setPriceToFinish($priceToFinish)
    {
        $this->priceToFinish = $priceToFinish;

        return $this;
    }

    /**
     * Get price to finish the step
     *
     * @return integer 
     */
    public function getPriceToFinish()
    {
        return $this->priceToFinish;
    }

    /**
     * Set if twe should display the pledge form or not
     *
     * @param boolean $displayPledgeForm
     * @return Step
     */
    public function setIsDisplayPledgeForm($displayPledgeForm)
    {
        $this->displayPledgeForm = $displayPledgeForm;

        return $this;
    }  

    /**
     * Tell if we should display the pledge action
     *
     * @return boolean 
     */
    public function isDisplayPledgeForm()
    {
        return $this->displayPledgeForm;
    }
}