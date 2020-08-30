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
    private const CLASS_TYPE_FINAL = 'Final';
    private const CLASS_TYPE_ABSTRACT = 'Abstract';
    private const CLASS_TYPE_NORMAL = 'Normal';

    private const  PROPERTIES_FILTER_LIST = [
        'public' => ReflectionProperty::IS_PUBLIC,
        'protected' => ReflectionProperty::IS_PROTECTED,
        'private' => ReflectionProperty::IS_PRIVATE,
        ];

    private const  METHODS_FILTER_LIST = [
        'public' => ReflectionMethod::IS_PUBLIC,
        'protected' => ReflectionMethod::IS_PROTECTED,
        'private' => ReflectionMethod::IS_PRIVATE,
    ];

    public function analyze(string $className): ClassesInfoUtil
    {
        try {
            $reflector = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new InvalidClassNameException('Invalid class name');
        }

        $classInfo = new ClassesInfoUtil($reflector->getShortName(), $this->getClassType($reflector));

        foreach (self::PROPERTIES_FILTER_LIST as $name => $filter) {
            $properties = $reflector->getProperties($filter);
            $classInfo->setProperties($name, \count($properties));
        }

        foreach (self::METHODS_FILTER_LIST as $name => $filter) {
            $methods = $reflector->getMethods($filter);
            $classInfo->setMethods($name, \count($methods));
        }

        return $classInfo;
    }

    private function getClassType(\ReflectionClass $reflector): string
    {
        if ($reflector->isFinal()) {
            return self::CLASS_TYPE_FINAL;
        }

        if ($reflector->isAbstract()) {
            return self::CLASS_TYPE_ABSTRACT;
        }

        return self::CLASS_TYPE_NORMAL;
    }
}
