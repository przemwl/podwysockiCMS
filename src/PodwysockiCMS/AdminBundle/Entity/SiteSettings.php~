<?php

namespace PodwysockiCMS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site Settings
 *
 * @ORM\Table(name="site_setting")
 * @ORM\Entity(repositoryClass="PodwysockiCMS\AdminBundle\Entity\Repositories\SiteSettingRepository")
 */
class SiteSettings 
{   
    /**
     * @var type integer
     * 
     * @ORM\Column(name="id",type="integer", nullable=false)
     * @ORM\ID
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var type string
     *
     * @ORM\Column(name="option_name", type="string", length=255, nullable=false)
     */
    private $optionName;
    
    /**
     * @var type string
     * 
     * @ORM\Column(name="option_value", type="string", length=255, nullable=false)
     */
    private $optionValue;

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
     * Set optionName
     *
     * @param string $optionName
     *
     * @return SiteSettings
     */
    public function setOptionName($optionName)
    {
        $this->optionName = $optionName;

        return $this;
    }

    /**
     * Get optionName
     *
     * @return string
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * Set optionValue
     *
     * @param string $optionValue
     *
     * @return SiteSettings
     */
    public function setOptionValue($optionValue)
    {
        $this->optionValue = $optionValue;

        return $this;
    }

    /**
     * Get optionValue
     *
     * @return string
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }
}
