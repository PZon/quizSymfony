<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
/**
     * @Route("/admin", name="app_admin")
     */
    public function dummyClassAdmin(){
       // throw new \Exception('admin CLASS should never be reached');
       
        return $this->render('admin/dashboard.html.twig');
     }
     
     /**
     * @Route("/admin/answers")
     */
    public function adminAnswers(){
    
        $this->denyAccessUnlessGranted('ROLE_COMMENT_ADMIN');

        return new Response('Pretend admin answer page, that should be private');
     }
}