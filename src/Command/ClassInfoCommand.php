<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Command;

use ITEA\PhpStaticAnalyzer\Analyzer\ClassInfoAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ClassInfoCommand class registers a console command which shows information about particular class.
 *
 * ClassInfoCommand extends from [[Symfony\Component\Console\Command\Command]] and registers `class-info` console command.
 *
 * Required parameter is full class name (with namespace) of the class that has to be analyzed.
 *
 * Usage:
 * Register command in your code:
 * ```
 * $application = new Application('PHP Static Analyzer', 'v1.0.0');
 * $command = new ClassInfoCommand(new ClassInfoAnalyzer());
 * $application->add($command);
 * $application->run();
 * ```
 * Run the console command:
 * ```
 * class-info 'Name\Space\ClassName'
 * ```
 *
 * The information to be returned in this command consists of:
 * - class short name, class type (normal, final, abstract)
 * - count of public, protected and private class properties
 * - count of public, protected and private class methods
 *
 * Command prints the information stated in the `execute()` method in the following format:
 * ```
 * Class: {{class_name}} is {{class_type}}
 * Properties:
 *     public: {{count}}
 *     protected: {{count}}
 *     private: {{count}}
 * Methods:
 *     public: {{count}}
 *     protected: {{count}}
 *     private: {{count}}
 * ```
 *
 * @author Alina Yavd <ya.alinka23@gmail.com>
 */
final class ClassInfoCommand extends Command
{
    protected static $defaultName = 'class-info';
    private ClassInfoAnalyzer $analyzer;

    public function __construct(ClassInfoAnalyzer $analyzer)
    {
        parent::__construct();
        $this->analyzer = $analyzer;
    }

    /**
     * Defines parameters for the command.
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Shows class properties and methods information.')
            ->addArgument(
                'class_name',
                InputArgument::REQUIRED,
                'Full class name to analyze.'
            )
        ;
    }

    /**
     * Runs the command `class-info` and prints the response to console.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $className = $input->getArgument('class_name');
        $classInfo = $this->analyzer->analyze($className);
        $classInfo->type = $classInfo->type ?? 'normal';

        $output->writeln(\sprintf("Class <info>%s</info> is <info>%s</info>.\n", $classInfo->name, $classInfo->type));

        $output->writeln(\sprintf("<info>Properties:</info>\n%s", \implode('', \array_map(function ($key, $value) {
            return \sprintf("    %s: %s \n", $key, $value);
        }, \array_keys($classInfo->properties), $classInfo->properties))));

        $output->writeln(\sprintf("<info>Methods:</info>\n%s", \implode('', \array_map(function ($key, $value) {
            return \sprintf("    %s: %s \n", $key, $value);
        }, \array_keys($classInfo->methods), $classInfo->methods))));

        return self::SUCCESS;
    }
}
