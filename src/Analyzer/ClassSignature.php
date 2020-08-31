<?php

declare(strict_types=1);

/*
 * This file is part of the "default-project" package.
 *
 * (c) Volodymyr Kupriienko <vladimir.kuprienko@itea.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ITEA\PhpStaticAnalyzer\Analyzer;

use ITEA\PhpStaticAnalyzer\ClassMember\AbstractClassMember;
use ITEA\PhpStaticAnalyzer\Collector\ClassSignatureCollector;
use ITEA\PhpStaticAnalyzer\Exception\ClassDoesNotExistException;

final class ClassSignature
{
    public function analyze(string $className): ClassSignatureCollector
    {
        $reflector = $this->getReflector($className);

        $info = new ClassSignatureCollector($reflector->getShortName(), $this->getClassType($reflector));

        foreach ($reflector->getProperties() as $property) {
            $info->incrementPropertyCounter($this->getAccessor($property));
        }

        foreach ($reflector->getMethods() as $method) {
            $info->incrementMethodCounter($this->getAccessor($method));
        }

        return $info;
    }

    /**
     * @throws ClassDoesNotExistException
     */
    private function getReflector(string $className): \ReflectionClass
    {
        try {
            $reflector = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new ClassDoesNotExistException(\sprintf('Class %s does not exist', $className), 0, $e);
        }

        return $reflector;
    }

    private function getClassType(\ReflectionClass $reflector): string
    {
        switch (true) {
            case $reflector->isFinal():
                return ClassSignatureCollector::TYPE_FINAL;

            case $reflector->isAbstract():
                return ClassSignatureCollector::TYPE_ABSTRACT;

            default:
                return ClassSignatureCollector::TYPE_NORMAL;
        }
    }

    /**
     * @param \ReflectionMethod|\ReflectionProperty $reflector
     */
    private function getAccessor($reflector): string
    {
        switch (true) {
            case $reflector->isPublic():
                return AbstractClassMember::ACCESSOR_PUBLIC;

            case $reflector->isProtected():
                return AbstractClassMember::ACCESSOR_PROTECTED;

            case $reflector->isPrivate():
                return AbstractClassMember::ACCESSOR_PRIVATE;

            default:
                throw new \LogicException('Unknown accessor.');
        }
    }
}
