<?php

declare(strict_types=1);

/*
 * This file is part of the "default-project" package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ITEA\PhpStaticAnalyzer\Command;

use ITEA\PhpStaticAnalyzer\Analyzer\ClassesInfoAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Dmytro Lytvynchuk <dmytrolutv@gmail.com>
 */
final class ClassesInfoCommand extends Command
{
    protected static $defaultName = 'classes-info';
    private ClassesInfoAnalyzer $analyzer;

    public function __construct(ClassesInfoAnalyzer $analyzer)
    {
        parent::__construct();
        $this->analyzer = $analyzer;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Gets info of needed classes')
            ->addArgument(
                'class_name',
                InputArgument::REQUIRED,
                'Full class name. For example: App\Service\DepositService'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $class_name = $input->getArgument('class_name');

        $info = $this->analyzer->analyze($class_name);

        if (\is_string($info)) {
            $output->writeln($info);

            return self::FAILURE;
        }
        $output->writeln($this->createOutputStr($info));

        return self::SUCCESS;
    }

    private function createOutputStr(array $info): string
    {
        return \sprintf(
            'Class: <info>%s</info> is <info>%s</info>
Properties:
    public: %d
    protected: %d
    private: %d
Methods:
    public: %d
    protected: %d
    private: %d', $info['name'], $info['type'], $info['properties']['public'], $info['properties']['protected'], $info['properties']['private'], $info['methods']['public'], $info['methods']['protected'], $info['methods']['private']);
    }
}
