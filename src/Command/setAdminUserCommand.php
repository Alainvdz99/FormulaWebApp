<?php

namespace App\Command;

use App\Service\SetAdminService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class setAdminUserCommand extends Command
{
    private $setAdmin;
    protected static $defaultName = 'app:admin';

    public function __construct(SetAdminService $setAdmin)
    {
        $this->setAdmin = $setAdmin;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->setAdmin->setAdminRole();

        $output->writeln('Successfully set admin');
    }

}