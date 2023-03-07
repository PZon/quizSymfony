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
            'last_username'=>$authenticationUtils->getLastUsername(),
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
     
     /**
     * @Route("/admin/login")
     */
    public function dummyClassAdminNr2(){
        return new Response('Pretend admin login page, that should be public');
     }

}
