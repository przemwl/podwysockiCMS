<?php

namespace PodwysockiCMS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PodwysockiCMS\AdminBundle\Forms\NewPageForm;
use PodwysockiCMS\AdminBundle\Entity\Pages;
use PodwysockiCMS\AdminBundle\Helpers\LinkValidator;


class AdminDashobardPagesController extends Controller
{
    public function indexAction()
    {
        $pages =  $this->get('doctrine')
            ->getRepository('AdminBundle:Pages')
            ->findAll();
        
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/pages-list.html.twig',array(
            'pages' => $pages
                ));
    }
    
    public function addNewPageAction(Request $request)
    {

        $pageTitle = $request->request->get('new_page_form')['pageTitle'];
        $pageContent = $request->request->get('new_page_form')['pageContent'];
        $link = isset($request->request->get('new_page_form')['pageContent']) ? 
                $request->request->get('new_page_form')['pageContent'] : '';
        $visibility = isset($request->request->get('new_page_form')['visibility']) ? 
                $request->request->get('new_page_form')['pageContent'] : 'visible';
       
        
        $page = new Pages();
        
        $page->setPageTitle($pageTitle)
            ->setPageContent($pageContent)
            ->setLink($link)
            ->setVisibility($visibility);
                
                
        $form = $this->createForm(NewPageForm::class, $page);
        
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        $checkLinks = $em->getRepository('AdminBundle:Pages')
                ->findBy(array(
                    'link' => $page->getLink()
                ));
        
        if ($form->isSubmitted() && $form->isValid() && empty($checkLinks)) {
            
            $em->persist($page);
            $em->flush();

            $this->addFlash(
                'notice',
                'Udało Ci się dodać stronę!'
            );

            return $this->redirectToRoute('admin_pages_edit',array('pageID' => $page->getId()));
            
        } else {
            if (!empty($checkLinks)) {
                $this->addFlash(
                    'error',
                    'Taka strona już znajduje się w bazie!'
                );                
            }

        }
        
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/page-single.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    
    public function editPageAction(Request $request, $pageID)
    {
        
        $page =  $this->get('doctrine')
            ->getRepository('AdminBundle:Pages')
            ->find($pageID);
        
        $form = $this->createForm(NewPageForm::class, $page);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->addFlash(
                'notice',
                'Zmiany zostały zapisane!'
            );
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            
            return $this->redirectToRoute('admin_pages_edit', array( 'pageID' => $pageID));
        }
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/page-single.html.twig', array(
            'form' => $form->createView(),
            'page' => $page 
        ));
    }
    
    public function removePageAction($pageID)
    {
        $page = $this->get('doctrine')
            ->getRepository('AdminBundle:Pages')
            ->find($pageID);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();
        
         $this->addFlash(
                'notice',
                'Strona została usunięta!'
               );
        
        return $this->redirectToRoute('admin_pages');
    }
            
    
}
