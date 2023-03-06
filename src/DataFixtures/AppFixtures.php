<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Tag;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuestionTagFactory;
use App\Factory\TagFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
    TagFactory::createMany(13);


     $questions=QuestionFactory::new()->createMany(30);   

     QuestionTagFactory::createMany(13, function() {
        return [
            'tag' => TagFactory::random(),
            'question' => QuestionFactory::random(),
        ];
    });
     
     QuestionFactory:: new()->unpublished()
                            ->many(5)
                            ->create();
    
    AnswerFactory::new()->createMany(50, function() use($questions){
        return[
            'question'=>$questions[array_rand($questions)],
        ];
    });

    AnswerFactory::new(function() use ($questions){
        return[
            'question'=>$questions[array_rand($questions)],
        ];
    })->needsApproval()->many(5)->create();

    UserFactory::createOne(['email' => 'admin@pp.pp',
                            'roles' => ['ROLE_ADMIN'],
    ]);

    UserFactory::createOne(['email' => 'user@pp.pp' ]);
    UserFactory::createMany(7);

    $manager->flush();
    }

}
