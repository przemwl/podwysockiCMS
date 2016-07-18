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
        
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/page-list.html.twig',array(
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
        $em = $this->getDoctrine()->getManager();
            
        $pageRepository =  $em->getRepository('AdminBundle:Pages');
        $page = $pageRepository->find($pageID);
                
        $categories = $pageRepository->assignCategories($page);
        
        $form = $this->createForm(NewPageForm::class, $page);
        
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $insertCategories = isset($request->request->get('new_page_form')['categories']) 
                    ? $request->request->get('new_page_form')['categories'] : '' ;
            $pageRepository->setCategories($page, $insertCategories);
            $this->addFlash(
                'notice',
                'Zmiany zostały zapisane!'
            );
            $em->persist($page);
            $em->flush();
            
            return $this->redirectToRoute('admin_pages_edit', array( 'pageID' => $pageID));
        }
        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/page-single.html.twig', array(
            'form' => $form->createView(),
            'page' => $page,
            'categories' => $categories
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
    
    public function duplicatePageAction($pageID)
    {
        $pageToDuplicate =  $this->get('doctrine')
            ->getRepository('AdminBundle:Pages')
            ->find($pageID);

        $pageToDuplicate->setPageTitle( $pageToDuplicate->getPageTitle() . ' ( copy ) ');
        $pageToDuplicate->setLink($pageToDuplicate->getLink() . '-copy');


        $em = $this->getDoctrine()->getManager();
        $em->detach($pageToDuplicate);
        $em->persist($pageToDuplicate);
        $em->flush();

        return $this->redirectToRoute('admin_pages');
    }
    
    
    public function bulkAction(Request $request)    
    {
        $action = $request->request->get('action');
        $bulkIDs = $request->request->get('bulkIDs');
        
        switch($action) {
            case 'delete':
               $this->bulkDelete($bulkIDs);
               break;
            case 'duplicate':
               $this->bulkDuplicate($bulkIDs);
               break;
            default:
                throw new \Exception('We didn\'t get any action');
        }    
        
        return $this->redirectToRoute('admin_pages');
    }
    
    
    public function bulkDelete($bulkIDs)
    {
        foreach($bulkIDs as $pageID) {
            $page =  $this->get('doctrine')
                ->getRepository('AdminBundle:Pages')
                ->find($pageID);
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }
        
         $this->addFlash(
                'notice',
                'Wybrane strony zostały usuniętę!'
               );
    }
    
    public function bulkDuplicate($bulkIDs)
    {
        foreach($bulkIDs as $pageID) {
            
            $pageRepo = $this->get('doctrine') 
               ->getRepository('AdminBundle:Pages');
            $pageToDuplicate =  $pageRepo->find($pageID);
            
            $newTitle = $this->findUnique('AdminBundle:Pages', 'PageTitle', 'pageTitle',$pageID);
            $newLink = $this->findUnique('AdminBundle:Pages', 'Link', 'link',$pageID);
            
            $pageToDuplicate->setPageTitle($newTitle);
            $LinkValidator = new LinkValidator($newLink);
            $pageToDuplicate->setLink($LinkValidator->getLink());
            
            
            $em = $this->getDoctrine()->getManager();
            $em->detach($pageToDuplicate);
            $em->persist($pageToDuplicate);
            $em->flush();
            
        }
    }
    
    public function findUnique($repository,$string,$propertyName,$pageID)
    {
        $Repo = $this->get('doctrine')
                ->getRepository($repository);
        
        $toDuplicate =  $Repo->find($pageID);
        
        $methodName = 'get' . $string;
        $newString =  $toDuplicate->$methodName()  . '-copy';
        
        $theSameString = $Repo->findBy(array(
                        $propertyName =>  $newString
                    ));
        while (!empty($theSameString)) {
            $newString .=  '-copy';
            $theSameString = $Repo->findBy(array(
                        $propertyName =>  $newString
                    ));
        }
        return $newString;
    }
    
}
