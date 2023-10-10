<?php

namespace App\Command;

use App\Entity\Difficulties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Define the command name and its description
#[AsCommand(
    name: 'app:create-difficulty-levels',
    description: 'Creates predefined difficulty levels in the system',
)]
class CreateDifficultyLevelsCommand extends Command
{
    private $entityManager;

    // Constructor method to inject the EntityManager
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            // Set the command name
            ->setName('app:create-difficulty-levels')
            // Set the command description
            ->setDescription('Create difficulty levels: Easy, Medium, Hard');
    }

    // This method will be executed when the command is called
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Define the difficulty levels
        $levels = ['Easy', 'Medium', 'Hard'];

        // Loop through each difficulty level and persist them in the database
        foreach ($levels as $level) {
            $difficulty = new Difficulties();
            $difficulty->setName($level);

            $this->entityManager->persist($difficulty);
        }

        // Flush the data to the database
        $this->entityManager->flush();

        // Output a success message
        $output->writeln('Difficulty levels created successfully.');

        return Command::SUCCESS;
    }
}
