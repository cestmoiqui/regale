<?php

namespace App\Command;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFakeMediaCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:generate-fake-media')
            ->setDescription('Generate fake media data for testing');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $media = new Media();
            $media->setName($faker->word);
            $media->setAltText($faker->sentence);
            $media->setFilename('https://source.unsplash.com/random?cuisine,food&' . rand(1, 1000000));            // Ici, nous récupérons une image aléatoire de cuisine
            $media->setType($faker->randomElement(['Image', 'Vidéo']));

            // Générer un ID d'article ou de recette existant de manière aléatoire
            $ownerType = $faker->randomElement(['Article', 'Recipe']);
            $ownerId = null;

            if ($ownerType === 'Article') {
                // Remplacez les valeurs par les IDs existants de vos articles
                $ownerId = $faker->numberBetween(1, 100); // Par exemple, entre 1 et 100
            } else {
                // Remplacez les valeurs par les IDs existants de vos recettes
                $ownerId = $faker->numberBetween(1, 50); // Par exemple, entre 1 et 50
            }

            $media->setMediaOwnerId($ownerId);
            $media->setMediaOwnerType($ownerType);

            $this->entityManager->persist($media);
        }

        $this->entityManager->flush();

        $output->writeln('Fake media data generated successfully.');

        return Command::SUCCESS;
    }
}
