<?php

declare(strict_types=1);

namespace ITEA\PhpStaticAnalyzer\Util;

/**
 * Return type of class and counters for every type its properties and methods.
 * Have additional flag $listArgument for list properties and methods.
 *
 * @author Fedotov Evgeniy aka FEV <trafaret@trafaret.kiev.ua>
 */
final class ShowDataAboutClass
{
    private int $counterPropertiesPublic = 0;
    private int $counterPropertiesProtected = 0;
    private int $counterPropertiesPrivate = 0;

    private int $counterMethodsPublic = 0;
    private int $counterMethodsProtected = 0;
    private int $counterMethodsPrivate = 0;

    public const CLASS_NORMAL = 'normal';
    public const CLASS_FINAL = 'final';
    public const CLASS_ABSTRACT = 'abstract';

    private string $classType;

    private array $propertiesList;
    private array $methodsList;

    public bool $listArgument = false;

    public function showFullDataAboutClass(string $fullNameClass, ?bool $listArgument = false): void
    {
        $reflector = new \ReflectionClass($fullNameClass);

        $this->listArgument = $listArgument;

        $this->getClassType($reflector);

        $this->getAllProperties($reflector);

        $this->getAllMethods($reflector);

        $this->showSymmaryInfo($reflector);
    }

    private function getClassType(\ReflectionClass $reflector): void
    {
        $this->classType = $this::CLASS_NORMAL;

        if ($reflector->isFinal()) {
            $this->classType = $this::CLASS_FINAL;
        }

        if ($reflector->isAbstract()) {
            $this->classType = $this::CLASS_ABSTRACT;
        }
    }

    private function getPropertyType(\ReflectionClass $reflector, string $propertyName): void
    {
        if ($reflector->getProperty($propertyName)->isPublic()) {
            $this->propertiesList[$propertyName] = 'public';
            ++$this->counterPropertiesPublic;
        }

        if ($reflector->getProperty($propertyName)->isProtected()) {
            $this->propertiesList[$propertyName] = 'protected';
            ++$this->counterPropertiesProtected;
        }

        if ($reflector->getProperty($propertyName)->isPrivate()) {
            $this->propertiesList[$propertyName] = 'private';
            ++$this->counterPropertiesPrivate;
        }
    }

    private function getMethodType(\ReflectionClass $reflector, string $methodName): void
    {
        if ($reflector->getMethod($methodName)->isPublic()) {
            $this->methodsList[$methodName] = 'public';
            ++$this->counterMethodsPublic;
        }

        if ($reflector->getMethod($methodName)->isProtected()) {
            $this->methodsList[$methodName] = 'protected';
            ++$this->counterMethodsProtected;
        }

        if ($reflector->getMethod($methodName)->isPrivate()) {
            $this->methodsList[$methodName] = 'private';
            ++$this->counterMethodsPrivate;
        }
    }

    private function getAllProperties(\ReflectionClass $reflector): void
    {
        $propertiesArray = $reflector->getProperties();

        foreach ($propertiesArray as $propertyName) {
            $propertyName = $propertyName->getName();

            $this->getPropertyType($reflector, $propertyName);
        }
    }

    private function getAllMethods(\ReflectionClass $reflector): void
    {
        $methodsArray = $reflector->getMethods();

        foreach ($methodsArray as $methodName) {
            $methodName = $methodName->getName();

            $this->getMethodType($reflector, $methodName);
        }
    }

    private function showSymmaryInfo(\ReflectionClass $reflector): void
    {
        echo 'Class: ' . $reflector->getName() . ' is ' . $this->classType . PHP_EOL;

        echo 'Properties:' . PHP_EOL;
        echo '    public: ' . $this->counterPropertiesPublic . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->propertiesList, 'public') as $propertyName) {
                echo '        ' . $propertyName . PHP_EOL;
            }
        }
        echo '    protected: ' . $this->counterPropertiesProtected . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->propertiesList, 'protected') as $propertyName) {
                echo '        ' . $propertyName . PHP_EOL;
            }
        }
        echo '    private: ' . $this->counterPropertiesPrivate . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->propertiesList, 'private') as $propertyName) {
                echo '        ' . $propertyName . PHP_EOL;
            }
        }

        echo PHP_EOL;

        echo 'Methods:' . PHP_EOL;
        echo '    public: ' . $this->counterMethodsPublic . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->methodsList, 'public') as $methodName) {
                echo '        ' . $methodName . PHP_EOL;
            }
        }
        echo '    protected: ' . $this->counterMethodsProtected . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->methodsList, 'protected') as $methodName) {
                echo '        ' . $methodName . PHP_EOL;
            }
        }
        echo '    private: ' . $this->counterMethodsPrivate . PHP_EOL;

        if ($this->listArgument) {
            foreach (\array_keys($this->methodsList, 'private') as $methodName) {
                echo '        ' . $methodName . PHP_EOL;
            }
        }
    }
}
