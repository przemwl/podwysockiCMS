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
                if($category->getID() == $term->getTerm()->getID()) {
                    $category->assigned = true;
                } else {
                    $category->assigned = false;
                }
            }
        }
        
        $page->categories = $categories;
    }
}
