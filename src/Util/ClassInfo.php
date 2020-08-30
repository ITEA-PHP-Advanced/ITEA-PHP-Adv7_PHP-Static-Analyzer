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

namespace ITEA\PhpStaticAnalyzer\Util;

use Reflection;
use ReflectionProperty;

/**
 * Describes type, properties and methods of the particular class.
 *
 * Returns object with the class following information:
 *     name (string) short name of the class
 *     type (string) class type (normal, final, abstract)
 *     properties (array) count of each property type (public, protected, private)
 *     methods (array) count of each method type (public, protected, private)
 *
 * @author Alina Yavd <ya.alinka23@gmail.com>
 */
final class ClassInfo
{
    private \ReflectionClass $reflector;
    public string $name;
    public string $type;
    public array $properties = [];
    public array $methods = [];
    private array $visibilities = [
        'public' => ReflectionProperty::IS_PUBLIC,
        'protected' => ReflectionProperty::IS_PROTECTED,
        'private' => ReflectionProperty::IS_PRIVATE,
    ];

    public function __construct($reflector)
    {
        $this->reflector = $reflector;

        $this->name = $this->reflector->getShortName();

        $modifier = $this->reflector->getModifiers();
        $types = Reflection::getModifierNames($modifier);
        $this->type = \array_shift($types);

        foreach ($this->visibilities as $key => $visibility) {
            $this->properties[$key] = \count($this->reflector->getProperties($visibility));
            $this->methods[$key] = \count($this->reflector->getMethods($visibility));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type ?? 'normal';
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
