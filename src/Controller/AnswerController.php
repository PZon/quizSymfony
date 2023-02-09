<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController{

    /**
     * @Route("/answers/{id}/vote", methods="POST", name="answer_vote")
     */
    public function commentVote(Answer $answer, Request $request, EntityManagerInterface $em){
        $direction= $request->request->get('direction');
        if ($direction ==='up'){
           $answer->commentsUpVote();
        }else{
          $answer->commentsDownVote(); 
        }

        $em->flush();
        $question=$answer->getQuestion();
        
        return $this->redirectToRoute('questionShow', ['slug'=> $question->getSlug()]);
    }

    /**
     * @Route("/answers/popular", name="popular_answers")
     */
    public function popularAnswers(AnswerRepository $ar){
      $answers = $ar->findMostPopular();

      return $this->render('answer/popularAnswer.html.twig', ['answers'=>$answers]);
    }
}