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

namespace ProxyManager\Signature\Exception;

use ReflectionClass;
use UnexpectedValueException;

/**
 * Exception for no found signatures
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 * @license MIT
 */
class MissingSignatureException extends UnexpectedValueException implements ExceptionInterface
{
<<<<<<< HEAD
=======
    /**
     * @param ReflectionClass $class
     * @param array           $parameters
     * @param string          $expected
     *
     * @return self
     */
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
    public static function fromMissingSignature(ReflectionClass $class, array $parameters, string $expected) : self
    {
        return new self(sprintf(
            'No signature found for class "%s", expected signature "%s" for %d parameters',
            $class->getName(),
            $expected,
            count($parameters)
        ));
    }
}
