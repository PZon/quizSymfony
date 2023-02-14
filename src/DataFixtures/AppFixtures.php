<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Tag;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use App\Factory\TagFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
    TagFactory::createMany(13);

     $questions=QuestionFactory::new()->createMany(13, function(){
        return[
        'tags'=>TagFactory::randomRange(0,3),
        ];
    });      
     
     QuestionFactory:: new()->unpublished()
                            ->createMany(3);
    
    AnswerFactory::new()->createMany(21, function() use($questions){
        return[
            'question'=>$questions[array_rand($questions)],
        ];
    });

    AnswerFactory::new(function() use ($questions){
        return[
            'question'=>$questions[array_rand($questions)],
        ];
    })->needsApproval()->many(10)->create();


    $manager->flush();
    }

}
