<?php

namespace PodwysockiCMS\AdminBundle\Entity;

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
    
    public function setCategories($page, $postCategoriesIDs)
    {
        $assignedCategoriesNumber = $this->countAssignedCategories($page);
        
        if(count($postCategoriesIDs) > $assignedCategoriesNumber) {
            $this->insertTermsRelations($page, $postCategoriesIDs);
        } 
        
        if(count($postCategoriesIDs) < $assignedCategoriesNumber) {
            $this->deleteTermsRelations($page, $postCategoriesIDs);
        }
    }
    
    
    public function insertTermsRelations($page, $postCategoriesIDs)
    {
        $em = $this->getEntityManager();
        foreach($postCategoriesIDs as $categoryID) {
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
    
    public function deleteTermsRelations($page, $postCategoriesIDs)
    {
        throw new \Exception('Deleting categories need to be done.');
    }
    
    public function countAssignedCategories($page)
    {
        $assignedCategoriesNumber = 0;
        
            foreach($page->categories as $category) {
                
                if(!isset($category->assigned)) {
                    break;
                }
                
                if($category->assigned == true) {
                    $assignedCategoriesNumber++;
                }
            }
         
        
        return $assignedCategoriesNumber;
    }
}
