<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestController
{
    /**
     * @Route("/test1")
     */
    public function test1(){
       return new Response('Respond from TestController method: test1');
    }

    /**
     * @Route("/test_two")
     */
    public function test2(){
        return new Response('Respond from TestController method: test2');
    }

    

}