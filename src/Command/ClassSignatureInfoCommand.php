<?php

declare(strict_types=1);

/*
 * This file is part of the "default-project" package.
 *
 * (c) Volodymyr Kupriienko <vladimir.kuprienko@itea.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ITEA\PhpStaticAnalyzer\Command;

use ITEA\PhpStaticAnalyzer\Analyzer\ClassSignature;
use ITEA\PhpStaticAnalyzer\Collector\ClassSignatureCollector;
use ITEA\PhpStaticAnalyzer\Exception\ClassDoesNotExistException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ClassSignatureInfoCommand extends Command
{
    private ClassSignature $classSignature;

    public function __construct(ClassSignature $classSignature)
    {
        parent::__construct();

        $this->classSignature = $classSignature;
    }

    protected function configure(): void
    {
        $this
            ->setName('info:class-signature')
            ->setDescription('Shows information about class by full class name')
            ->addArgument(
                'full-class-name',
                InputArgument::REQUIRED,
                'Full class name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fullClassName = $input->getArgument('full-class-name');

        try {
            $result = $this->classSignature->analyze($fullClassName);
        } catch (ClassDoesNotExistException $e) {
            $output->writeln(\sprintf('<error>%s</error>', $e->getMessage()));

            return self::FAILURE;
        }

        $formattedOutput = $this->createOutput($result);
        $output->writeln($formattedOutput);

        return self::SUCCESS;
    }

    protected function createOutput(ClassSignatureCollector $result): string
    {
        $output = \sprintf("Class %s is %s\n", $result->getShortName(), $result->getType());

        $properties = $result->getProperties();
        $output .= "Properties:\n";
        $output .= \sprintf("\tpublic: %d\n", \count($properties->public()));
        $output .= \sprintf("\tprotected: %d\n", \count($properties->protected()));
        $output .= \sprintf("\tprivate: %d\n", \count($properties->private()));

        $output .= "Methods:\n";
        $output .= \sprintf("\tpublic: %d\n", $result->getMethods()->public()->count());
        $output .= \sprintf("\tprotected: %d\n", $result->getMethods()->protected()->count());
        $output .= \sprintf("\tprivate: %d\n", $result->getMethods()->private()->count());

        return $output;
    }
}
