<?php

namespace PodwysockiCMS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TermsRelations
 *
 * @ORM\Table(name="terms_relations")
 * @ORM\Entity
 */
class TermsRelations
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
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id",nullable=true, onDelete="CASCADE", unique=false)
     */
    private $term = 1;

    /**
     * @var \Pages
     *
     * @ORM\ManyToOne(targetEntity="Pages")
     * @ORM\JoinColumn(name="term_order", referencedColumnName="id",nullable=true, onDelete="CASCADE", unique=false)
     *      
     */
    private $termOrder;

    
        /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->term = new ArrayCollection();
        $this->termOrder = new ArrayCollection();
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
     * Add term
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Categories $term
     *
     * @return TermsRelations
     */
    public function addTerm(\PodwysockiCMS\AdminBundle\Entity\Categories $term)
    {
        $this->term[] = $term;

        return $this;
    }

    /**
     * Remove term
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Categories $term
     */
    public function removeTerm(\PodwysockiCMS\AdminBundle\Entity\Categories $term)
    {
        $this->term->removeElement($term);
    }

    /**
     * Get term
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Add termOrder
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Pages $termOrder
     *
     * @return TermsRelations
     */
    public function addTermOrder(\PodwysockiCMS\AdminBundle\Entity\Pages $termOrder)
    {
        $this->termOrder[] = $termOrder;

        return $this;
    }

    /**
     * Remove termOrder
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Pages $termOrder
     */
    public function removeTermOrder(\PodwysockiCMS\AdminBundle\Entity\Pages $termOrder)
    {
        $this->termOrder->removeElement($termOrder);
    }

    /**
     * Get termOrder
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTermOrder()
    {
        return $this->termOrder;
    }

    /**
     * Set term
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Categories $term
     *
     * @return TermsRelations
     */
    public function setTerm(\PodwysockiCMS\AdminBundle\Entity\Categories $term = null)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Set termOrder
     *
     * @param \PodwysockiCMS\AdminBundle\Entity\Pages $termOrder
     *
     * @return TermsRelations
     */
    public function setTermOrder(\PodwysockiCMS\AdminBundle\Entity\Pages $termOrder = null)
    {
        $this->termOrder = $termOrder;

        return $this;
    }
}
