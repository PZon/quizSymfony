<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="homePage")
     */
    public function homepage(Environment $environment){
        /* $html= $environment->render('question/homepage.html.twig');
        return new Response($html); */
       return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/quests/{anyWord}", name="questionShow")
     */
    public function show($anyWord){

        $answers = [
            'answer One',
            'answer Two',
            'answer Three',
        ];

        dump($anyWord, $this);
        //dd($anyWord, $this);

        return $this->render('question/show.html.twig',[
            'question'=>ucwords(str_replace('-',' ',$anyWord)),
            'answers'=>$answers,
        ]);
    }

}