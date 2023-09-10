<?php

namespace App\Command;

use App\Entity\Difficulties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-difficulty-levels',
    description: 'Add a short description for your command',
)]
class CreateDifficultyLevelsCommand extends Command
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
            ->setName('app:create-difficulty-levels')
            ->setDescription('Create difficulty levels: Facile, Moyen, Difficile');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $levels = ['Facile', 'Moyen', 'Difficile'];

        foreach ($levels as $level) {
            $difficulty = new Difficulties();
            $difficulty->setName($level);

            $this->entityManager->persist($difficulty);
        }

        $this->entityManager->flush();

        $output->writeln('Difficulty levels created successfully.');

        return Command::SUCCESS;
    }
}
