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
final class ClassesAnalizeStructureAnalyzer
{
    /**
     * This method analized your php class and return informatiob about it.
     * @param string $class_src_path
     * @return array
     */
    public function analyze(string $class_src_path): array
    {
        $data = [];

        try {
            $reflector = new \ReflectionClass($class_src_path);
        } catch (\ReflectionException $e) {
            return null;
        }
        $data['class_name'] = $reflector->getShortName();

        $data['class_type'] = $this->getTypeClass($reflector);

        [$data['prop_public'], $data['prop_protected'], $data['prop_private']] = $this->countAccesibleProperties($reflector);

        [$data['met_public'], $data['met_protected'], $data['met_private']] = $this->countAccesibleMethods($reflector);

        return $data;
    }

    public function getTypeClass($reflector): string
    {
        if ($reflector->isFinal()) {
            return 'Final';
        }

        if ($reflector->isAbstract()) {
            return 'Abstract';
        }

        return 'Normal';
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
