<?php

namespace PodwysockiCMS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardCategoryController extends Controller
{
    public function indexAction()
    {
        return new Response('Kategorie');
    }
    
}
