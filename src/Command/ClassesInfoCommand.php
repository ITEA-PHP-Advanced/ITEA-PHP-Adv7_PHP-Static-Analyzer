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
use ITEA\PhpStaticAnalyzer\Exception\InvalidClassNameException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This class creates a command and shows the result of this command.
 *
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
                'Full class name. For example: "App\Service\DepositService"'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $className = $input->getArgument('class_name');

        $classInfo = $this->analyzer->analyze($className);

        try {
            $classInfo = $this->analyzer->analyze($className);
        } catch (InvalidClassNameException $e) {
            $output->writeln($e);

            return self::FAILURE;
        }

        $output->writeln($this->createOutputStr($classInfo));

        return self::SUCCESS;
    }

    /**
     * Creating output string with information of class.
     *
     * @return string return the finished string
     */
    private function createOutputStr(object $classInfo): string
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
    private: %d', $classInfo->getClassName(), $classInfo->getClassType(), $classInfo->getProperties('public'), $classInfo->getProperties('protected'), $classInfo->getProperties('private'), $classInfo->getMethods('public'), $classInfo->getMethods('protected'), $classInfo->getMethods('private'));
    }
}
