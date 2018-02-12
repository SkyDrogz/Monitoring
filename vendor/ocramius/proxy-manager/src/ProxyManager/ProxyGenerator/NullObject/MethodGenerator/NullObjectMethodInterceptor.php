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

namespace ProxyManager\ProxyGenerator\NullObject\MethodGenerator;

use ProxyManager\Generator\MethodGenerator;
<<<<<<< HEAD
use ProxyManager\Generator\Util\IdentifierSuffixer;
=======
use ProxyManager\Generator\Util\UniqueIdentifierGenerator;
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
use Zend\Code\Reflection\MethodReflection;

/**
 * Method decorator for null objects
 *
 * @author Vincent Blanchon <blanchon.vincent@gmail.com>
 * @license MIT
 */
class NullObjectMethodInterceptor extends MethodGenerator
{
    /**
     * @param \Zend\Code\Reflection\MethodReflection $originalMethod
     *
     * @return self|static
     */
    public static function generateMethod(MethodReflection $originalMethod) : self
    {
        /* @var $method self */
<<<<<<< HEAD
        $method = static::fromReflectionWithoutBodyAndDocBlock($originalMethod);

        if ($originalMethod->returnsReference()) {
            $reference = IdentifierSuffixer::getIdentifier('ref');

            $method->setBody("\$$reference = null;\nreturn \$$reference;");
        }

=======
        $method = static::fromReflection($originalMethod);

        if ('void' === (string) $originalMethod->getReturnType()) {
            $method->setBody('');

            return $method;
        }

        if ($originalMethod->returnsReference()) {
            $reference = UniqueIdentifierGenerator::getIdentifier('ref');

            $method->setBody("\$$reference = null;\nreturn \$$reference;");

            return $method;
        }

        $method->setBody('');

>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
        return $method;
    }
}
