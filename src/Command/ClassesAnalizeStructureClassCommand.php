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

use ITEA\PhpStaticAnalyzer\Analyzer\ClassesAnalizeStructureAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Alexandr Bovsunovsky <bovsunovsky@rambler.ru>
 */
final class ClassesAnalizeStructureClassCommand extends Command
{
    protected static $defaultName = 'classes-analize-structure';
    private $analyzer;

    public function __construct(ClassesAnalizeStructureAnalyzer $analyzer)
    {
        parent::__construct();
        $this->analyzer = $analyzer;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Gets analize structure of classe')
            ->addArgument(
                'class_src_path',
                InputArgument::REQUIRED,
                'Absolute path to PHP class source code to analyze.'
            )

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $class_src_path = $input->getArgument('class_src_path');

        $data = $this->analyzer->analyze($class_src_path);

        $output->writeln(\sprintf('Class : <info>%s</info> , is :  <info>%s</info>' . PHP_EOL .
            'Properties :' . PHP_EOL .
            '   public: <info>%d</info>' . PHP_EOL .
            '   protected: <info>%d</info>' . PHP_EOL .
            '   private: <info>%d</info>' . PHP_EOL .
            'Methods :' . PHP_EOL .
            '   public: <info>%d</info>' . PHP_EOL .
            '   protected: <info>%d</info>' . PHP_EOL .
            '   private: <info>%d</info>' . PHP_EOL
            , $data['class_name'], $data['class_type'],
            $data['prop_public'],$data['prop_protected'],$data['prop_private'],
            $data['met_public'], $data['met_protected'], $data['met_private']));

        return self::SUCCESS;
    }
}
