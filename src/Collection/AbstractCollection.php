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

namespace ITEA\PhpStaticAnalyzer\Collection;

use ITEA\PhpStaticAnalyzer\ClassMember\AbstractClassMember;

abstract class AbstractCollection implements \Countable
{
    protected array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Filters items using given predicate and returns new instance of this collection with filtered items.
     */
    public function filter(callable $predicate): self
    {
        return new static(...\array_filter($this->items, $predicate));
    }

    /**
     * Returns class members with public access modifier.
     */
    public function public(): self
    {
        return $this->filter(function (AbstractClassMember $member) {
            return $member->isPublic();
        });
    }

    /**
     * Returns class members with protected access modifier.
     */
    public function protected(): self
    {
        return $this->filter(function (AbstractClassMember $member) {
            return $member->isProtected();
        });
    }

    /**
     * Returns class members with private access modifier.
     */
    public function private(): self
    {
        return $this->filter(function (AbstractClassMember $member) {
            return $member->isPrivate();
        });
    }

    /**
     * Returns count of items in this collection.
     */
    public function count(): int
    {
        return \count($this->items);
    }
}
