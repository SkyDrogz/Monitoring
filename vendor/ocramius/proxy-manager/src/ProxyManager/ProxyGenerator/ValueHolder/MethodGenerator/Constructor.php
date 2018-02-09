<?php
<<<<<<< HEAD
=======
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator\ValueHolder\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
use ProxyManager\ProxyGenerator\Util\Properties;
use ProxyManager\ProxyGenerator\Util\UnsetPropertiesGenerator;
use ReflectionClass;
<<<<<<< HEAD
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Reflection\MethodReflection;
use Zend\Code\Reflection\ParameterReflection;
=======
use Zend\Code\Generator\ParameterGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Reflection\MethodReflection;
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440

/**
 * The `__construct` implementation for lazy loading proxies
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class Constructor extends MethodGenerator
{
    /**
<<<<<<< HEAD
=======
     * Constructor
     *
     * @param ReflectionClass   $originalClass
     * @param PropertyGenerator $valueHolder
     *
     * @return self
     *
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
     * @throws \Zend\Code\Generator\Exception\InvalidArgumentException
     */
    public static function generateMethod(ReflectionClass $originalClass, PropertyGenerator $valueHolder) : self
    {
        $originalConstructor = self::getConstructor($originalClass);

<<<<<<< HEAD
        /* @var $constructor self */
        $constructor = $originalConstructor
            ? self::fromReflectionWithoutBodyAndDocBlock($originalConstructor)
            : new self('__construct');

=======
        $constructor = $originalConstructor
            ? self::fromReflection($originalConstructor)
            : new self('__construct');

        $constructor->setDocBlock('{@inheritDoc}');
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
        $constructor->setBody(
            'static $reflection;' . "\n\n"
            . 'if (! $this->' . $valueHolder->getName() . ') {' . "\n"
            . '    $reflection = $reflection ?: new \ReflectionClass('
            . var_export($originalClass->getName(), true)
            . ");\n"
            . '    $this->' . $valueHolder->getName() . ' = $reflection->newInstanceWithoutConstructor();' . "\n"
            . UnsetPropertiesGenerator::generateSnippet(Properties::fromReflectionClass($originalClass), 'this')
            . '}'
<<<<<<< HEAD
            . ($originalConstructor ? self::generateOriginalConstructorCall($originalConstructor, $valueHolder) : '')
=======
            . self::generateOriginalConstructorCall($originalClass, $valueHolder)
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
        );

        return $constructor;
    }

    private static function generateOriginalConstructorCall(
<<<<<<< HEAD
        MethodReflection $originalConstructor,
        PropertyGenerator $valueHolder
    ) : string {
        return "\n\n"
            . '$this->' . $valueHolder->getName() . '->' . $originalConstructor->getName() . '('
            . implode(
                ', ',
                array_map(
                    function (ParameterReflection $parameter) : string {
                        return ($parameter->isVariadic() ? '...' : '') . '$' . $parameter->getName();
                    },
                    $originalConstructor->getParameters()
=======
        ReflectionClass $class,
        PropertyGenerator $valueHolder
    ) : string {
        $originalConstructor = self::getConstructor($class);

        if (! $originalConstructor) {
            return '';
        }

        $constructor = self::fromReflection($originalConstructor);

        return "\n\n"
            . '$this->' . $valueHolder->getName() . '->' . $constructor->getName() . '('
            . implode(
                ', ',
                array_map(
                    function (ParameterGenerator $parameter) : string {
                        return ($parameter->getVariadic() ? '...' : '') . '$' . $parameter->getName();
                    },
                    $constructor->getParameters()
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
                )
            )
            . ');';
    }

    /**
     * @param ReflectionClass $class
     *
     * @return MethodReflection|null
     */
    private static function getConstructor(ReflectionClass $class)
    {
        $constructors = array_map(
            function (\ReflectionMethod $method) : MethodReflection {
                return new MethodReflection(
                    $method->getDeclaringClass()->getName(),
                    $method->getName()
                );
            },
            array_filter(
                $class->getMethods(),
                function (\ReflectionMethod $method) : bool {
                    return $method->isConstructor();
                }
            )
        );

        return reset($constructors) ?: null;
    }
}
