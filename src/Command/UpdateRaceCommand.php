<?php

namespace App\Command;

use App\Service\UpdateRaceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateRaceCommand extends Command
{
    private $updateRace;
    protected static $defaultName = 'app:update-race';

    public function __construct(UpdateRaceService $updateRace)
    {
        $this->updateRace = $updateRace;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->updateRace->updateRaces();

        $output->writeln('Successfully updated active race');
    }

}