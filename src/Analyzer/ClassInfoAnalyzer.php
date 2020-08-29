<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Analyzer;

use Reflection;
use ReflectionProperty;

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
     * @param string $className full class name to be analyzed
     *
     * @return object object with the following information:
     *                name (string) short name of the class
     *                type (string) class type (normal, final, abstract)
     *                properties (array) count of each property type (public, protected, private)
     *                methods (array) count of each method type (public, protected, private)
     *
     * @author Alina Yavd <ya.alinka23@gmail.com>
     */
    public function analyze(string $className): object
    {
        try {
            $reflector = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            return (object) [];
        }

        $modifier = $reflector->getModifiers();
        $types = Reflection::getModifierNames($modifier);

        $properties = [
            'public' => \count($reflector->getProperties(ReflectionProperty::IS_PUBLIC)),
            'protected' => \count($reflector->getProperties(ReflectionProperty::IS_PROTECTED)),
            'private' => \count($reflector->getProperties(ReflectionProperty::IS_PRIVATE)),
        ];
        $methods = [
            'public' => \count($reflector->getMethods(ReflectionProperty::IS_PUBLIC)),
            'protected' => \count($reflector->getMethods(ReflectionProperty::IS_PROTECTED)),
            'private' => \count($reflector->getMethods(ReflectionProperty::IS_PRIVATE)),
        ];

        $info = [
            'name' => $reflector->getShortName(),
            'type' => \array_shift($types),
            'properties' => $properties,
            'methods' => $methods,
        ];

        return (object) $info;
    }
}
