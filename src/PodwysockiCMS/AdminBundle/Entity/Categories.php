<?php

namespace PodwysockiCMS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PodwysockiCMS\AdminBundle\Helpers\LinkValidator;
/**
 * Categories
 *
 * @ORM\Table(name="categories", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_3AF34668D5B80441", columns={"category_name"})})
 * @ORM\Entity
 */
class Categories
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
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="category_description", type="string", length=255, nullable=false)
     */
    private $categoryDescription;
    
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
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Categories
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     *
     * @return Categories
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

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Categories
     */
    public function setLink($link)
    {
        if(empty($link) || $link == null) {
            $link = $this->categoryName;
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
     * Set categoryDescription
     *
     * @param string $categoryDescription
     *
     * @return Categories
     */
    public function setCategoryDescription($categoryDescription)
    {
        $this->categoryDescription = $categoryDescription;

        return $this;
    }

    /**
     * Get categoryDescription
     *
     * @return string
     */
    public function getCategoryDescription()
    {
        return $this->categoryDescription;
    }
}
