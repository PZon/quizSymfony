<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
     $questions=QuestionFactory::new()->createMany(7);      
     
     QuestionFactory:: new()->unpublished()
                            ->createMany(3);
    
    AnswerFactory::new()->createMany(7, function() use($questions){
        return[
            'question'=>$questions[array_rand($questions)],
        ];
    });
    
    $manager->flush();
    }

}
