<?php

namespace App\Command;

use Symfony\Component\Process\Process;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StepCacheCommand extends Command
{
    protected static $defaultName = 'app:step:cache';
    protected static $defaultDescription = 'Add a short description for your command';
    

    private $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $step = $this->cache->get('app.current_step', function ($item) {
        //     $process = new Process(['git', 'tag', '-l', '--points-at', 'HEAD']);
        //     $process->mustRun();
        //     $item->expiresAfter(30);

        //     return $process->getOutput();
        // });
        // $output->writeln($step);

        return 0;
    }
}
