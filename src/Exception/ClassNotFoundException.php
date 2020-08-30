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

namespace ITEA\PhpStaticAnalyzer\Exception;

/**
 * Exception thrown if passed class in ClassInfoAnalyzer is not found.
 *
 * @author Alina Yavd <ya.alinka23@gmail.com>
 */
class ClassNotFoundException extends \RuntimeException
{
}
