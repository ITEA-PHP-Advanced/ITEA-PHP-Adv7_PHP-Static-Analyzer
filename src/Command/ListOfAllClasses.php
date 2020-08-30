<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Command;

use ITEA\PhpStaticAnalyzer\Analyzer\ListOfAllClassesAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class for console command list-classes.
 * Show all available names of classes.
 *
 * @author Fedotov Evgeniy aka FEV <trafaret@trafaret.kiev.ua>
 */
final class ListOfAllClasses extends Command
{
    protected static $defaultName = 'list-classes';

    protected function configure(): void
    {
        $this
            ->setDescription('Show list of all classes')
            ->addArgument(
                'projectSrcPath',
                InputArgument::REQUIRED,
                'Absolute path to PHP project source code to analyze.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $projectSrcPath = $input->getArgument('projectSrcPath');

        $analyzer = new ListOfAllClassesAnalyzer();
        $analyzer->getAvailableClasses($projectSrcPath);

        return self::SUCCESS;
    }
}
