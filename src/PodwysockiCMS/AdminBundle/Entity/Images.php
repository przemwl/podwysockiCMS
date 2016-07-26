<?php

namespace PodwysockiCMS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




/**
 * Pages
 *
 * @ORM\Table(name="images")
 * @ORM\Entity
 */

class Images 
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
   * @ORM\Column(name="image_url", type="string", length=255)
   */  
   private $url;
   
   
  /**
   * @var string
   * @Assert\NotBlank()
   * @ORM\Column(name="image_title", type="string", length=255)
   */    
   private $title;
   
  /**
   * @var string
   * @ORM\Column(name="image_alt", type="string", length=255)
   */  
   private $alt;
   

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
     * Set url
     *
     * @param string $url
     *
     * @return Images
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Images
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
     * Set alt
     *
     * @param string $alt
     *
     * @return Images
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}
