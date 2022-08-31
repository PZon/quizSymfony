<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController{

    /**
     * @Route("/comments/{id}/vote/{direction<up|down>}", methods="POST")
     */
    public function commentVote($id, $direction, LoggerInterface $logger){
        if ($direction ==='up'){
            $logger->info('voting UP');
            $currentVoteCount = rand(7,13);
        }else{
            $logger->info('voting DOWN');
            $currentVoteCount = rand(1,6);
        }
        //return new JsonResponse(['votes'=>$currentVoteCount]); //działanie takie samo jak poniżej
        return $this->json(['votes'=>$currentVoteCount]);
    }
}