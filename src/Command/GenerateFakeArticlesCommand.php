<?php

namespace App\Command;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFakeArticlesCommand extends Command
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
            ->setName('app:generate-fake-articles')
            ->setDescription('Generate fake articles for testing');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) { // Générer 10 articles (vous pouvez ajuster ce nombre)
            $article = new Article();
            $article->setTitle($faker->sentence(4));
            $article->setSlug($faker->slug);
            $article->setContent($faker->paragraph(6));
            $article->setFeaturedText($faker->sentence(8));
            $article->setCreatedAt($faker->dateTimeThisMonth());
            $article->setUpdatedAt($faker->optional()->dateTimeThisMonth());

            $this->entityManager->persist($article);
        }

        $this->entityManager->flush();

        $output->writeln('Faux articles générés avec succès.');

        return Command::SUCCESS;
    }
}
