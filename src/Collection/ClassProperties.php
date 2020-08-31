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

use ITEA\PhpStaticAnalyzer\ClassMember\Property;

final class ClassProperties extends AbstractCollection
{
    public function __construct(Property ...$items)
    {
        parent::__construct($items);
    }

    public function add(Property $item): void
    {
        $this->items[] = $item;
    }
}
