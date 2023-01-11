<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
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
    public function homepage(QuestionRepository $repository){

        //$repository=$emi->getRepository(Question::class);
       // $questions=$repository->findBy([],['askedAt'=>'DESC']);
        $questions=$repository->findAllAskedOrderedByNewest();
        //dd($questions);

       return $this->render('question/homepage.html.twig', ['questions'=>$questions,]);
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
    }

    /**
     * @Route("/quests/{slug}", name="questionShow")
     */
    public function show($slug, MarkdownHelper $markdownHelper, EntityManagerInterface $em){

        if($this->isDebug){
            $this->logger->info('We are in DEBUG MODE');
        }

        $repository = $em->getRepository(Question::class);
        /**  @var Question|null $question */
        $question = $repository->findOneBy(['slug' => $slug]);

        if(!$question){
            throw $this->createNotFoundException(sprintf('No question found for slug "%s" - pzon', $slug));
        }
        
        $answers = [
            'answer `txt` One',
            'answer Two',
            'answer Three',
        ];

        return $this->render('question/show.html.twig',[
            'question'=>$question,
            'answers'=>$answers,
        ]);
    }
}