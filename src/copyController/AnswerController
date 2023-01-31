<?php

namespace App\Controller;

use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController{

    /**
     * @Route("/comments/{id}/vote/{direction<up|down>}", methods="POST", name="answer_vote")
     */
    public function commentVote(Answer $answer, $direction, LoggerInterface $logger, Request $request, EntityManagerInterface $em){
        
        if ($direction ==='up'){
            $logger->info('voting UP');
            $answer->setVotes($answer->getVotes()+1);
           // $currentVoteCount = rand(7,130);
        }else{
            $logger->info('voting DOWN');
            $answer->setVotes($answer->getVotes() - 1);
           // $currentVoteCount = rand(1,6);
        }
        //return new JsonResponse(['votes'=>$currentVoteCount]); //działanie takie samo jak poniżej
        //return $this->json(['votes'=>$currentVoteCount]);
        return $this->json(['votes' => $answer->getVotes()]);
    }
}