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

use ITEA\PhpStaticAnalyzer\Exception\InvalidClassNameException;
use ITEA\PhpStaticAnalyzer\Util\ClassesInfoUtil;
use ReflectionMethod;
use ReflectionProperty;

/**
 * This class contain a logic to analyze other class and return this information:
 * Class name and type,
 * Quantity public, protected and private properties and methods.
 *
 * @author Dmytro Lytvynchuk <dmytrolutv@gmail.com>
 */
final class ClassesInfoAnalyzer
{
    private const FINAL = 'Final';
    private const ABSTRACT = 'Abstract';

    private array $propertiesFilterList = [
        'public' => ReflectionProperty::IS_PUBLIC,
        'protected' => ReflectionProperty::IS_PROTECTED,
        'private' => ReflectionProperty::IS_PRIVATE,
        ];

    private array $methodsFilterList = [
        'public' => ReflectionMethod::IS_PUBLIC,
        'protected' => ReflectionMethod::IS_PROTECTED,
        'private' => ReflectionMethod::IS_PRIVATE,
    ];

    public function analyze(string $className): ClassesInfoUtil
    {
        $classInfo = new ClassesInfoUtil();

        try {
            $reflector = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new InvalidClassNameException('Invalid class name');
        }

        $classInfo->setClassName($reflector->getShortName());

        $classInfo->setClassType($this->getClassType($reflector));

        foreach ($this->propertiesFilterList as $name => $filter) {
            $properties = $reflector->getProperties($filter);
            $classInfo->setProperties($name, \count($properties));
        }

        foreach ($this->methodsFilterList as $name => $filter) {
            $methods = $reflector->getMethods($filter);
            $classInfo->setMethods($name, \count($methods));
        }

        return $classInfo;
    }

    private function getClassType(\ReflectionClass $reflector): string
    {
        if ($reflector->isFinal()) {
            return self::FINAL;
        }

        if ($reflector->isAbstract()) {
            return self::ABSTRACT;
        }

        return 'Normal';
    }
}
