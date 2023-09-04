<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Créer 20 tags fictifs
        for ($i = 0; $i < 20; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word);

            // Ajoutez des appels à des setters ici si vous avez d'autres champs

            $manager->persist($tag);
        }

        // Sauvegardez les objets en base de données
        $manager->flush();
    }
}
