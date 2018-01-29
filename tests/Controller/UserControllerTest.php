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
    public function testLoginPage()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/login');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testIndex()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
