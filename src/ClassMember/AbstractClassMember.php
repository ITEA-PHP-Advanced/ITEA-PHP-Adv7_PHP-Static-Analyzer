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

namespace ITEA\PhpStaticAnalyzer\ClassMember;

abstract class AbstractClassMember
{
    public const ACCESSOR_PUBLIC = 'public';
    public const ACCESSOR_PROTECTED = 'protected';
    public const ACCESSOR_PRIVATE = 'private';

    protected string $accessor;

    public function __construct(string $accessor)
    {
        $this->accessor = $accessor;
    }

    /**
     * Checks whether current class member is public.
     */
    public function isPublic(): bool
    {
        return self::ACCESSOR_PUBLIC === $this->accessor;
    }

    /**
     * Checks whether current class member is protected.
     */
    public function isProtected(): bool
    {
        return self::ACCESSOR_PROTECTED === $this->accessor;
    }

    /**
     * Checks whether current class member is private.
     */
    public function isPrivate(): bool
    {
        return self::ACCESSOR_PRIVATE == $this->accessor;
    }
}
