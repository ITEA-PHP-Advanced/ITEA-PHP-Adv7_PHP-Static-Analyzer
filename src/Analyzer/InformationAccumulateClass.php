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

class InformationAccumulateClass
{
    private $className;
    private $classType;
    private $propPublic;
    private $propProtected;
    private $propPrivate;
    private $metPrivate;
    private $metProtected;
    private $metPublic;

    public function __construct($className, $classType, $propPublic, $propProtected, $propPrivate, $metPrivate, $metProtected, $metPublic)
    {
        $this->className = $className;
        $this->classType = $classType;
        $this->propPublic = $propPublic;
        $this->propProtected = $propProtected;
        $this->propPrivate = $propPrivate;
        $this->metPrivate = $metPrivate;
        $this->metProtected = $metProtected;
        $this->metPublic = $metPublic;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return mixed
     */
    public function getClassType()
    {
        return $this->classType;
    }

    /**
     * @return mixed
     */
    public function getPropPublic()
    {
        return $this->propPublic;
    }

    /**
     * @return mixed
     */
    public function getPropProtected()
    {
        return $this->propProtected;
    }

    /**
     * @return mixed
     */
    public function getPropPrivate()
    {
        return $this->propPrivate;
    }

    /**
     * @return mixed
     */
    public function getMetPrivate()
    {
        return $this->metPrivate;
    }

    /**
     * @return mixed
     */
    public function getMetProtected()
    {
        return $this->metProtected;
    }

    /**
     * @return mixed
     */
    public function getMetPublic()
    {
        return $this->metPublic;
    }
}
