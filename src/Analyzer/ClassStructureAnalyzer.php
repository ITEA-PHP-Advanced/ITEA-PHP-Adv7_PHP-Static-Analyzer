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

/**
 * @author Alexandr Bovsunovsky <bovsunovsky@rambler.ru>
 */
final class ClassStructureAnalyzer
{
    public const FINAL_CLASS = 'Final';
    public const ABSTRACT_CLASS = 'Abstract';
    public const NORMAL_CLASS = 'Normal';

    /**
     * This method analized your php class and return informatiob about it.
     *
     * @return array
     */
    public function analyze(string $classSrcPath): ?object
    {
        try {
            $reflector = new \ReflectionClass($classSrcPath);

            $className = $reflector->getShortName();

            $classType = $this->getTypeClass($reflector);

            [$propPublic, $propProtected, $propPrivate] = $this->countAccesibleProperties($reflector);

            [$metPublic, $metProtected, $metPrivate] = $this->countAccesibleMethods($reflector);

            return  new InformationAccumulateClass($className, $classType, $propPublic, $propProtected, $propPrivate, $metPublic, $metProtected, $metPrivate);
        } catch (\ReflectionException $e) {
            return null;
        }
    }

    public function getTypeClass($reflector): string
    {
        if ($reflector->isFinal()) {
            return self::FINAL_CLASS;
        }

        if ($reflector->isAbstract()) {
            return self::ABSTRACT_CLASS;
        }

        return self::NORMAL_CLASS;
    }

    public function countAccesibleProperties($reflector): array
    {
        $properties = $reflector->getProperties();
        $publicProp = 0;
        $protectedProp = 0;
        $privateProp = 0;

        foreach ($properties as $prop) {
            if ($prop->isPrivate()) {
                ++$privateProp;
            }

            if ($prop->isProtected()) {
                ++$protectedProp;
            }

            if ($prop->isPublic()) {
                ++$publicProp;
            }
        }

        return [$publicProp, $protectedProp, $privateProp];
    }

    public function countAccesibleMethods($reflector): array
    {
        $methods = $reflector->getMethods();
        $publicMet = 0;
        $protectedMet = 0;
        $privateMet = 0;

        foreach ($methods as $met) {
            if ($met->isPrivate()) {
                ++$privateMet;
            }

            if ($met->isProtected()) {
                ++$protectedMet;
            }

            if ($met->isPublic()) {
                ++$publicMet;
            }
        }

        return [$publicMet, $protectedMet, $privateMet];
    }
}
