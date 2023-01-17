<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
     for($i=0; $i<3; $i++){
        $question = new Question();
        $question->setName('Missing pants')
                ->setSlug('missing-pants-'.rand(0,100))
                ->setVotes(rand(-13,13))
                ->setQuestion('Some strange sentence BLE BLE BLE ...?');

            if (rand(1,10)>2){
                $question->setAskedAt(new \DateTimeImmutable(sprintf('-%d days', rand(1, 100))));
            }
            $manager->persist($question);
            $manager->flush();
     }
            
    }
}
