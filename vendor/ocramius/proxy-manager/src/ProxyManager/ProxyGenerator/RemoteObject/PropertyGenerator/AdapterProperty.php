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

namespace ProxyManager\ProxyGenerator\RemoteObject\PropertyGenerator;

use ProxyManager\Factory\RemoteObject\AdapterInterface;
<<<<<<< HEAD
use ProxyManager\Generator\Util\IdentifierSuffixer;
=======
use ProxyManager\Generator\Util\UniqueIdentifierGenerator;
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440
use Zend\Code\Generator\PropertyGenerator;

/**
 * Property that contains the remote object adapter
 *
 * @author Vincent Blanchon <blanchon.vincent@gmail.com>
 * @license MIT
 */
class AdapterProperty extends PropertyGenerator
{
    /**
     * Constructor
     *
     * @throws \Zend\Code\Generator\Exception\InvalidArgumentException
     */
    public function __construct()
    {
<<<<<<< HEAD
        parent::__construct(IdentifierSuffixer::getIdentifier('adapter'));
=======
        parent::__construct(UniqueIdentifierGenerator::getIdentifier('adapter'));
>>>>>>> ab3d9a9318e69673c0df4c25f62c5b8952937440

        $this->setVisibility(self::VISIBILITY_PRIVATE);
        $this->setDocBlock('@var \\' . AdapterInterface::class . ' Remote web service adapter');
    }
}
