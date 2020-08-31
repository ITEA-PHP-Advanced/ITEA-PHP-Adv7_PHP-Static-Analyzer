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

namespace ITEA\PhpStaticAnalyzer\Collector;

use ITEA\PhpStaticAnalyzer\ClassMember\Method;
use ITEA\PhpStaticAnalyzer\ClassMember\Property;
use ITEA\PhpStaticAnalyzer\Collection\ClassMethods;
use ITEA\PhpStaticAnalyzer\Collection\ClassProperties;

final class ClassSignatureCollector
{
    public const TYPE_NORMAL = 'normal';
    public const TYPE_ABSTRACT = 'abstract';
    public const TYPE_FINAL = 'final';

    private string $shortName;
    private string $type;
    private ClassProperties $properties;
    private ClassMethods $methods;

    public function __construct(string $shortName, string $type)
    {
        $this->shortName = $shortName;
        $this->type = $type;
        $this->properties = new ClassProperties();
        $this->methods = new ClassMethods();
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getProperties(): ClassProperties
    {
        return $this->properties;
    }

    public function getMethods(): ClassMethods
    {
        return $this->methods;
    }

    public function incrementPropertyCounter(string $accessor): void
    {
        $this->properties->add(new Property($accessor));
    }

    public function incrementMethodCounter(string $accessor): void
    {
        $this->methods->add(new Method($accessor));
    }
}
