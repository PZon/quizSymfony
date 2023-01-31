<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController{

    /**
     * @Route("/comments/{id}/vote", methods="POST", name="answer_vote")
     */
    public function commentVote(Answer $answer, Request $request, EntityManagerInterface $em){
        $direction= $request->request->get('direction');
        if ($direction ==='up'){
           $answer->commentsUpVote();
        }else{
          $answer->commentsDownVote(); 
        }

        $em->flush();
        
        //return new JsonResponse(['votes'=>$currentVoteCount]); //działanie takie samo jak poniżej
        return $this->json(['votes'=>$answer->getVotes()]);
    }
}