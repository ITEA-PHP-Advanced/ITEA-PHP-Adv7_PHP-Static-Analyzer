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

/**
 * This class storage information about other class.
 *
 * @author Dmytro Lytvynchuk <dmytrolutv@gmail.com>
 */
class ClassesInfoUtil
{
    private string $className;
    private string $classType;

    private array $properties = [];
    private array $methods = [];

    public function __construct(string $className, string $classType)
    {
        $this->className = $className;
        $this->classType = $classType;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getClassType(): string
    {
        return $this->classType;
    }

    public function setProperties($name, $quantity): void
    {
        $this->properties[$name] = $quantity;
    }

    public function getProperties(string $type): int
    {
        return $this->properties[$type];
    }

    public function setMethods($name, $quantity): void
    {
        $this->methods[$name] = $quantity;
    }

    public function getMethods(string $type): int
    {
        return $this->methods[$type];
    }
}
