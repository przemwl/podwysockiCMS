<?php

namespace PodwysockiCMS\AdminBundle\Entity\Repositories;

use PodwysockiCMS\AdminBundle\Entity\Pages;

class PagesRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function assignCategories(Pages $page)
    {
        $em = $this->getEntityManager();
        $categories = $em->getRepository('AdminBundle:Categories')->findAll();
        $query = $em->createQuery('SELECT u FROM AdminBundle:TermsRelations u WHERE u.termOrder=' . $page->getID());
        $terms_relations = $query->getResult();
        
        foreach($categories as &$category) {
            foreach($terms_relations as $term) {
                    $category->assigned = false;
            }
        }
        
        foreach($categories as &$category) {
            foreach($terms_relations as $term) {
                if($category->getID() == $term->getTerm()->getID()) {
                    $category->assigned = true;
                }
            }
        }
        
        $page->categories = $categories;
    }
    
    public function setCategories($page, $postedCategoriesIDs)
    {
        if($postedCategoriesIDs == '') {
            $countPostedCategoriesIDs = 0;
        } else {
            $countPostedCategoriesIDs = count($postedCategoriesIDs);
        }
        $assignedCategoriesNumber = $this->countAssignedCategories($page);

        if($countPostedCategoriesIDs > $assignedCategoriesNumber) {
            $this->insertTermsRelations($page, $postedCategoriesIDs);
        } 
        
        if($countPostedCategoriesIDs < $assignedCategoriesNumber) {
            $this->deleteTermsRelations($page, $postedCategoriesIDs);
        }
    }
    
    
    public function insertTermsRelations($page, $postedCategoriesIDs)
    {
        $em = $this->getEntityManager();
        foreach($postedCategoriesIDs as $categoryID) {
            $query = $em->createQuery('SELECT u FROM AdminBundle:TermsRelations u WHERE u.termOrder=' . $page->getID() . 'AND u.term=' . $categoryID);
            $terms_relations = $query->getResult();
            if(empty($terms_relations)) {
                $newTermRelations = new TermsRelations();
                $category = $em->find('AdminBundle:Categories',$categoryID);
                $newTermRelations->setTerm($category);
                $newTermRelations->setTermOrder($page);
                $em->persist($newTermRelations);
                $em->flush();
            }
        }
    }
    
    public function deleteTermsRelations($page, $postedCategoriesIDs)
    {
        $em = $this->getEntityManager();
       
        if($postedCategoriesIDs == 0) {
            $q = $em->createQuery('delete from AdminBundle:TermsRelations u where u.termOrder=' . $page->getID());
            $numDeleted = $q->execute();
        } else {
            foreach($page->categories as $category) {
                if(array_search($category->getID(), $postedCategoriesIDs) === false) {
                    //var_dump($postedCategoriesIDs);die();
                    $q = $em->createQuery('delete from AdminBundle:TermsRelations u where u.term=' . $category->getID());
                    $numDeleted = $q->execute();
                }
            }
        }
    }
    
    public function countAssignedCategories($page)
    {
        $assignedCategoriesNumber = 0;
        
        if(isset($page->categories)) {
            foreach($page->categories as $category) {

                if(!isset($category->assigned)) {
                    break;
                }

                if($category->assigned == true) {
                    $assignedCategoriesNumber++;
                }
            }
        }
        
        return $assignedCategoriesNumber;
    }
}
