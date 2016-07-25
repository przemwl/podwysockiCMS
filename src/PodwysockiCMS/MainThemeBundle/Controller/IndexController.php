<?php

namespace PodwysockiCMS\MainThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainThemeBundle:Index:index.html.twig');
    }
    
    public function pageAction($page)
    {
        $page = $this->getDoctrine()
                ->getRepository('AdminBundle:Pages')->findBy(array('link' => $page));
        
        if(count($page) > 1) {
            throw new Exception('Strona ma zdublowany link!
                Przejdź do panelu administracyjnego i 
                zmień link na unikatowy');
        }
        
        return $this->render('MainThemeBundle:Index:page.html.twig',array(
            'page' => $page[0]
        ));
    }
}
