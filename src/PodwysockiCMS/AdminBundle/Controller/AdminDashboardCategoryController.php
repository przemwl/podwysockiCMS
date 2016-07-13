<?php

namespace PodwysockiCMS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PodwysockiCMS\AdminBundle\Entity\Categories;
use PodwysockiCMS\AdminBundle\Forms\NewCategoryForm;

class AdminDashboardCategoryController extends Controller
{
    public function indexAction()
    {
        $categories = $this->getDoctrine()
        ->getRepository('AdminBundle:Categories')
        ->findAll();
        
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        
        foreach($categories as $category) {
            
            $catID = $category->getID();
            $query = $em->createQuery("SELECT u FROM AdminBundle:TermsRelations u WHERE u.term=$catID");
            $terms_relations = $query->getResult();
            
            $category->innerPages = array_map(function($term){
                return array(
                    'pageTitle' => $term->getTermOrder()->getPageTitle(),
                    'pageID'     => $term->getTermOrder()->getID()
                );
            },$terms_relations);
  
        }
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/category-list.html.twig',array(
                'categories' => $categories));
    }
    
    public function addNewAction(Request $request)
    {
        $categoryName = $request->request->get('new_category_form')['categoryName'];
        $categoryDescription = $request->request->get('new_category_form')['categoryDescription'];
        $link = isset($request->request->get('new_category_form')['link']) ? 
                $request->request->get('new_page_form')['link'] : '';
        
        $category = new Categories();
        
        $category->setCategoryName($categoryName)
            ->setCategoryDescription($categoryDescription)
            ->setLink($link);
                
                
        $form = $this->createForm(NewCategoryForm::class, $category);
        
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        $checkLinks = $em->getRepository('AdminBundle:Categories')
                ->findBy(array(
                    'link' => $category->getLink()
                ));
        
        if ($form->isSubmitted() && $form->isValid() && empty($checkLinks)) {
            
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Udało Ci się dodać kategorię!'
            );

            return $this->redirectToRoute('admin_categories_edit',array('categoryID' => $category->getId()));
            
        } else {
            if (!empty($checkLinks)) {
                $this->addFlash(
                    'error',
                    'Taka kategoria już znajduje się w bazie!'
                );                
            }

        }
        
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/category-single.html.twig',array(
            'form' => $form->createView()
        ));
    }
    
    public function editAction(Request $request, $categoryID)
    {
        $category = $this->getDoctrine()
        ->getRepository('AdminBundle:Categories')
        ->find($categoryID);
        
        $form = $this->createForm(NewCategoryForm::class, $category);
        
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
        
            $this->addFlash(
                'notice',
                'Zmiany zostały zapisane!'
            );
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            
            return $this->redirectToRoute('admin_categories_edit', array( 'categoryID' => $categoryID));
        }
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/category-single.html.twig', array(
            'form' => $form->createView(),
            'category' => $category
        ));
    }
    
    public function removeAction($categoryID)
    {
        $category = $this->get('doctrine')
            ->getRepository('AdminBundle:Categories')
            ->find($categoryID);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        
         $this->addFlash(
                'notice',
                'Kategoria została usunięta!'
               );
        
        return $this->redirectToRoute('admin_categories');
    }
    
}
