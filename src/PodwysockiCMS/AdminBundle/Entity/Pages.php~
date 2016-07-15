<?php

namespace PodwysockiCMS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use PodwysockiCMS\AdminBundle\Helpers\LinkValidator;


/**
 * Pages
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="PodwysockiCMS\AdminBundle\Entity\PagesRepository")
 */
class Pages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="page_title", type="string", length=255)
     */
    private $pageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="page_content", type="string", length=255, nullable=true)
     */
    private $pageContent;


    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(name="link", type="string", length=255,unique=true, nullable=false)
     */    
    private $link;
    
    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(name="visibility", type="string", length=25,unique=false, nullable=false)
     */    
    private $visibility;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="parent", type="integer",unique=false, nullable=true)
     */    
    private $parent;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="published", type="datetime", nullable=false)
     */    
    private $published;   

    public function __construct()
    {
        $this->published = new \DateTime('now');
    }
    
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
     * Set pageTitle
     *
     * @param string $pageTitle
     *
     * @return Pages
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set pageContent
     *
     * @param string $pageContent
     *
     * @return Pages
     */
    public function setPageContent($pageContent)
    {
        $this->pageContent = $pageContent;

        return $this;
    }

    /**
     * Get pageContent
     *
     * @return string
     */
    public function getPageContent()
    {
        return $this->pageContent;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Pages
     */
    public function setLink($link)
    {
        if(empty($link) || $link == null) {
            $link = $this->pageTitle;
        }
        
        $LinkValidator = new LinkValidator($link);
        $this->link = $LinkValidator->getLink();
        
        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set visibility
     *
     * @param string $visibility
     *
     * @return Pages
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return Pages
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     *
     * @return Pages
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }
}
