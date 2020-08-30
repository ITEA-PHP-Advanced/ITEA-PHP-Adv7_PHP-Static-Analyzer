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

namespace ITEA\PhpStaticAnalyzer\Analyzer;

use ITEA\PhpStaticAnalyzer\Exception\ClassNotFoundException;
use ITEA\PhpStaticAnalyzer\Util\ClassInfo;

/**
 * ClassInfoAnalyzer class analyzes the class by it's name.
 * Can be used along with ClassInfoCommand class to print the information to the console.
 *
 * @author Alina Yavd <ya.alinka23@gmail.com>
 */
final class ClassInfoAnalyzer
{
    /**
     * Analyzes the passed class by it's full name.
     *
     * @param string $className class name with namespace to be analyzed
     *
     * @return ClassInfo object with the class information
     */
    public function analyze(string $className): ClassInfo
    {
        try {
            $reflector = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new ClassNotFoundException(\sprintf('Class %s not found.', $className));
        }

        return new ClassInfo($reflector);
    }
}
