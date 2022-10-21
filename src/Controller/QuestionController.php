<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class QuestionController extends AbstractController
{   
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger , bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

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
    public function show($anyWord, MarkdownHelper $markdownHelper){

        if($this->isDebug){
            $this->logger->info('We are in DEBUG MODE');
        }
        
        $answers = [
            'answer `txt` One',
            'answer Two',
            'answer Three',
        ];

        //dump($anyWord, $this);
        //dd($anyWord, $this);

        $questionTxt = "I've been turned into a cat, any thoughts on how to turn back? While I'm **adorable**, I don't really care for cat food.";
       /* $parsedQuestionTxt = $cache->get('markdown_'.md5($questionTxt), function() use ($questionTxt,$markdownParser){
            return $markdownParser->transformMarkdown($questionTxt);
        });*/
       // $parsedQuestionTxt = $markdownParser->transformMarkdown($questionTxt);
          $parsedQuestionTxt = $markdownHelper->parse($questionTxt);   

       //dd($markdownParser);
       //dump($cache);

        return $this->render('question/show.html.twig',[
            'question'=>ucwords(str_replace('-',' ',$anyWord)),
            'answers'=>$answers,
            //'questionTxt'=>$questionTxt,
            'questionTxt'=>$parsedQuestionTxt,
        ]);
    }

}