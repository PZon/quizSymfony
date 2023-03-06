<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
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
     * @Route("/{page<\d+>}", name="homePage")
     */
    public function homepage(QuestionRepository $repository, int $page=1){
        
       $queryBilder = $repository->createAskedOrderedByNewestQueryBuilder();

       $pagerfanta = new Pagerfanta(new QueryAdapter($queryBilder));
       $pagerfanta->setMaxPerPage(5);
       $pagerfanta->setCurrentPage($page);

       return $this->render('question/homepage.html.twig', ['pager'=>$pagerfanta,]);
    }

    /**
     * @Route("/quests/new")
     */
    public function new(){
        $this->denyAccessUnlessGranted('ROLE_USER');

        return new Response('Sounds like a GREAT feature for V2!');
    }

    /**
     * @Route("/quests/{slug}", name="questionShow")
     */
    public function show(Question $question){

        if($this->isDebug){
            $this->logger->info('We are in DEBUG MODE');
        }
        
        return $this->render('question/show.html.twig',[
            'question'=>$question,
        ]);
    }

    /**
     * @Route("/quests/{slug}/vote", name="app_question_vote", methods="POST")
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $em){
       $direction = $request->request->get('direction');
       if($direction === 'up'){
        $question->upVote();
       }elseif($direction === 'down'){
        $question->downVote();
       }

       $em->flush();

       return $this->redirectToRoute('questionShow', ['slug'=> $question->getSlug()]);
     
    }
}