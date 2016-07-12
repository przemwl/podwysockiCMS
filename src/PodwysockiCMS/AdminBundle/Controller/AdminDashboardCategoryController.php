<?php

namespace PodwysockiCMS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardCategoryController extends Controller
{
    public function indexAction()
    { 
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('pages.page_title,categories.category_name')
                ->from('AdminBundle:Pages','pages')
                ->innerJoin('AdminBundle:TermsRelations','terms_relations')
                ->leftJoin('AdminBundle:Categories','categories');
        $categories = $query->getQuery()->execute();
        
           
                
                
//        $categories = $this->getDoctrine()
//        ->getRepository('AdminBundle:Categories')
//        ->findAll();
       
        //select pages.page_title,categories.category_name from pages inner join terms_relations on pages.id=terms_relations.term_order left outer join categories on terms_relations.term_id=categories.id;

       return $this->render('AdminBundle:AdminDashobard:dashboard-pages/category-list.html.twig',array(
                'categories' => $categories));
    }
    
}
