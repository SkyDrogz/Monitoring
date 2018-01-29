<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/user'];
        yield ['/user/new'];
        yield ['/user/edit/1'];
        yield ['/user/consultation'];
        yield ['/system'];
        yield ['/system/new'];
        yield ['/system/edit/1'];
        yield ['/system/consultation'];
        yield ['/entreprise'];
        yield ['/entreprise/new'];
        yield ['/entreprise/edit/1'];
        yield ['/entreprise/consultation'];
    }
}
