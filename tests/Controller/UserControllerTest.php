<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserConsultation()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/user/consultation');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
