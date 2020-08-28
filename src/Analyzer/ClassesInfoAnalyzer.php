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

use ReflectionMethod;
use ReflectionProperty;

final class ClassesInfoAnalyzer
{
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

    public function analyze(string $class_name)
    {
        $info = [];

        try {
            $reflector = new \ReflectionClass($class_name);
        } catch (\ReflectionException $e) {
            return 'Invalid class name';
        }

        $info['name'] = $reflector->getShortName();

        $info['type'] = $this->getClassType($reflector);

        foreach ($this->propertiesFilterList as $name => $filter) {
            $properties = $reflector->getProperties($filter);
            $info['properties'][$name] = \count($properties);
        }

        foreach ($this->propertiesFilterList as $name => $filter) {
            $properties = $reflector->getMethods($filter);
            $count = 0;

            foreach ($properties as $method) {
                if ($method->class == $class_name) {
                    ++$count;
                }
            }
            $info['methods'][$name] = $count;
        }

        return $info;
    }

    private function getClassType(\ReflectionClass $reflector): string
    {
        if ($reflector->isFinal()) {
            return 'Final';
        }

        if ($reflector->isAbstract()) {
            return 'Abstract';
        }

        if ($reflector->isInterface()) {
            return 'Interface';
        }

        return 'Normal';
    }
}
