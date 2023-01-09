<?php

namespace App\Controller;

use App\Entity\Question;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/quests/new")
     */
    public function new(EntityManagerInterface $emi){
        $question = new Question();
        $question->setName('Missing pants')
                ->setSlug('missing-pants-'.rand(0,100))
                ->setQuestion('Some strange sentence BLE BLE BLE ...?');

            if (rand(1,10)>2){
                $question->setAskedAt(new \DateTimeImmutable(sprintf('-%d days', rand(1, 100))));
            }

            $emi->persist($question);
            $emi->flush();

       return new Response(sprintf('Well hallo! The shiny new question is id #%d, slug: %s',
            $question->getId(),
            $question->getSlug()    
        ));

        //return new Response('bele text');
    }

    /**
     * @Route("/quests/{slug}", name="questionShow")
     */
    public function show($slug, MarkdownHelper $markdownHelper, EntityManagerInterface $emi){

        if($this->isDebug){
            $this->logger->info('We are in DEBUG MODE');
        }

     //   $repository = $emi->getRepository(Question::class);
     //   $question = $repository->findOneBy(['slug' => $slug]);

      //  if(!$question){
      //      throw $this->createNotFoundException(sprintf('no question found for slug "%s"', $slug));
      //  }

     //   dd($question);
        
        $answers = [
            'answer `txt` One',
            'answer Two',
            'answer Three',
        ];

        $questionTxt = "I've been turned into a cat, any thoughts on how to turn back? While I'm **adorable**, I don't really care for cat food.";
        $parsedQuestionTxt = $markdownHelper->parse($questionTxt);   

        return $this->render('question/show.html.twig',[
            'question'=>ucwords(str_replace('-',' ',$slug)),
            'answers'=>$answers,
            //'questionTxt'=>$questionTxt,
            'questionTxt'=>$parsedQuestionTxt,
        ]);
    }
}