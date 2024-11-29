<?php

namespace App\DataFixtures;


use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class LoadPostData extends Fixture
{

    protected $faker;


    public function load(ObjectManager $manager): void
    {
       
        $this->faker = Factory::create();

        for ( $i = 1; $i <= 1000; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->sentence($nbWords = 6, $variableNbWords = true));
            $post->setLead($this->faker->text($maxNbChars = 300));
            $post->setContent($this->faker->text($maxNbChars = 700));
            $post->setCreatedAt($this->faker->dateTimeThisMonth);

            // Add to register
            $manager->persist($post);
            


        }

        // Send to database
        $manager->flush();
        
    }
}
