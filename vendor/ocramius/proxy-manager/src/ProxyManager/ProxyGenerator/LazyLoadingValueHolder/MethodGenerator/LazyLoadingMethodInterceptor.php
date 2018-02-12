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

namespace ProxyManager\ProxyGenerator\LazyLoadingValueHolder\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
use ProxyManager\Generator\Util\ProxiedMethodReturnExpression;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Reflection\MethodReflection;

/**
 * Method decorator for lazy loading value holder objects
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class LazyLoadingMethodInterceptor extends MethodGenerator
{
    /**
<<<<<<< HEAD
=======
     * @param \Zend\Code\Reflection\MethodReflection $originalMethod
     * @param \Zend\Code\Generator\PropertyGenerator $initializerProperty
     * @param \Zend\Code\Generator\PropertyGenerator $valueHolderProperty
     *
     * @return self
     *
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
     * @throws \Zend\Code\Generator\Exception\InvalidArgumentException
     */
    public static function generateMethod(
        MethodReflection $originalMethod,
        PropertyGenerator $initializerProperty,
        PropertyGenerator $valueHolderProperty
    ) : self {
        /* @var $method self */
<<<<<<< HEAD
        $method            = static::fromReflectionWithoutBodyAndDocBlock($originalMethod);
=======
        $method            = static::fromReflection($originalMethod);
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
        $initializerName   = $initializerProperty->getName();
        $valueHolderName   = $valueHolderProperty->getName();
        $parameters        = $originalMethod->getParameters();
        $methodName        = $originalMethod->getName();
        $initializerParams = [];
        $forwardedParams   = [];

        foreach ($parameters as $parameter) {
            $parameterName       = $parameter->getName();
            $variadicPrefix      = $parameter->isVariadic() ? '...' : '';
            $initializerParams[] = var_export($parameterName, true) . ' => $' . $parameterName;
            $forwardedParams[]   = $variadicPrefix . '$' . $parameterName;
        }

        $method->setBody(
            '$this->' . $initializerName
            . ' && $this->' . $initializerName
            . '->__invoke($this->' . $valueHolderName . ', $this, ' . var_export($methodName, true)
            . ', array(' . implode(', ', $initializerParams) .  '), $this->' . $initializerName . ");\n\n"
            . ProxiedMethodReturnExpression::generate(
                '$this->' . $valueHolderName . '->' . $methodName . '(' . implode(', ', $forwardedParams) . ')',
                $originalMethod
            )
        );
<<<<<<< HEAD
=======
        $method->setDocBlock('{@inheritDoc}');
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440

        return $method;
    }
}
