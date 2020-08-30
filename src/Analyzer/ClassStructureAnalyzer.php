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
    const FINALCLASS = 'Final';
    const ABSTRACTCLASS = 'Abstract';
    const NORMALCLASS = 'Normal';

    /**
     * This method analized your php class and return informatiob about it.
     * @param string $class_src_path
     * @return array
     */
    public function analyze(string $class_src_path): object
    {
        $data = new InformationAccumulateClass();

        try {
            $reflector = new \ReflectionClass($class_src_path);

            $data->className = $reflector->getShortName();

            $data->classType = $this->getTypeClass($reflector);

            [$data->propPublic, $data->propProtected, $data->propPrivate] = $this->countAccesibleProperties($reflector);

            [$data->metPublic, $data->metProtected, $data->metPrivate] = $this->countAccesibleMethods($reflector);

            return $data;
        } catch (\ReflectionException $e) {
            return null;
        }

    }

    public function getTypeClass($reflector): string
    {
        if ($reflector->isFinal()) {
            return self::FINALCLASS;
        }

        if ($reflector->isAbstract()) {
            return self::ABSTRACTCLASS;
        }

        return self::NORMALCLASS;
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
