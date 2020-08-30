<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Analyzer;

use ITEA\PhpStaticAnalyzer\Util\PhpFileUtil;
use PhpCsFixer\Finder;

/**
 * Class for getting all available names of classes from php files at destination path.
 *
 * @author Fedotov Evgeniy aka FEV <trafaret@trafaret.kiev.ua>
 */
final class ListOfAllClassesAnalyzer
{
    private function getFinder(string $projectSrcPath): Finder
    {
        return Finder::create()
            ->in($projectSrcPath)
            ->name('/^[A-Z]+\.php$/')
            ;
    }

    public function getAvailableClasses(string $projectSrcPath): void
    {
        $finder = $this->getFinder($projectSrcPath);

        echo 'Founded classes:' . PHP_EOL;

        foreach ($finder as $phpFilePath) {
            $classNamespace = PhpFileUtil::getClassNameFromFile($phpFilePath->getRealPath());

            try {
                $reflector = new \ReflectionClass($classNamespace);
                $className = $reflector->getName();

                echo ' - ' . $className . PHP_EOL;
            } catch (\ReflectionException $e) {
            }
        }
    }
}
