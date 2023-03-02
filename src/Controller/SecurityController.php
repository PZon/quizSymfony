<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
       throw new \Exception('logout() should never be reached');
    }

     /**
     * @Route("/admin", name="app_admin")
     */
    public function dummyClassAdmin(){
        throw new \Exception('admin CLASS should never be reached');
     }
}
