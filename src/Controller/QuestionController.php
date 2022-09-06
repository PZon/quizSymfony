<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

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
    public function show($anyWord, MarkdownParserInterface $markdownParser, CacheInterface $cache){

        $answers = [
            'answer `txt` One',
            'answer Two',
            'answer Three',
        ];

        //dump($anyWord, $this);
        //dd($anyWord, $this);

        $questionTxt = "I've been turned into a cat, any thoughts on how to turn back? While I'm **adorable**, I don't really care for cat food.";
        $parsedQuestionTxt = $cache->get('markdown_'.md5($questionTxt), function() use ($questionTxt,$markdownParser){
            return $markdownParser->transformMarkdown($questionTxt);
        });
       // $parsedQuestionTxt = $markdownParser->transformMarkdown($questionTxt);

        return $this->render('question/show.html.twig',[
            'question'=>ucwords(str_replace('-',' ',$anyWord)),
            'answers'=>$answers,
            //'questionTxt'=>$questionTxt,
            'questionTxt'=>$parsedQuestionTxt,
        ]);
    }

}