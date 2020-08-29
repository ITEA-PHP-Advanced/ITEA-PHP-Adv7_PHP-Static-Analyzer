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
    public string $className;
    public string $classType;

    public array $properties = [];
    public array $methods = [];

    public function setClassName($className): void
    {
        $this->className = $className;
    }

    public function setClassType($classType): void
    {
        $this->classType = $classType;
    }

    public function setProperties($name, $quantity): void
    {
        $this->properties[$name] = $quantity;
    }

    public function setMethods($name, $quantity): void
    {
        $this->methods[$name] = $quantity;
    }
}
