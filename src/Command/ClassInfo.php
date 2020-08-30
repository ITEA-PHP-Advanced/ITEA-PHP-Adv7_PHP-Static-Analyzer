<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Command;

use ITEA\PhpStaticAnalyzer\Util\ShowDataAboutClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class for console command class-info.
 * Show short info about class.
 * Have additional option --full for list properties and methods.
 *
 * @author Fedotov Evgeniy aka FEV <trafaret@trafaret.kiev.ua>
 */
final class ClassInfo extends Command
{
    protected static $defaultName = 'class-info';

    protected function configure(): void
    {
        $this
            ->setDescription('Show info about class')
            ->addArgument(
                'fullNameClass',
                InputArgument::REQUIRED,
                'Name class for analyze.'
            )
            ->addOption(
                'full',
                'f',
                InputOption::VALUE_NONE,
                'Additional info about properties and methods.',
                null
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fullNameClass = $input->getArgument('fullNameClass');

        if ($input->getOption('full')) {
            $fullInfo = true;
        } else {
            $fullInfo = false;
        }

        $classInfo = new ShowDataAboutClass();

        $classInfo->ShowFullDataAboutclass($fullNameClass, $fullInfo);

        return self::SUCCESS;
    }
}
