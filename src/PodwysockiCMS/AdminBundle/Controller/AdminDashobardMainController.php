<?php

namespace PodwysockiCMS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminDashobardMainController extends Controller
{
    public function DashboardMainAction()
    { 
       $user = $this->get('security.token_storage')->getToken()->getUser();
//     $avatarSrc = $user->getAvatarSrc();
       $username = $user->getUsername();
//        
        return $this->render('AdminBundle:AdminDashobard:dashboard-pages/main.html.twig',array(
            'username' => $username
//            'avatarSrc' =>  $avatarSrc
        ));
    }
    
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AdminBundle:AdminDashobard:login/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );       
    }
}
