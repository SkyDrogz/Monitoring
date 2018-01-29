<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
  public function testLoginPage()
  {
    $client = static::createClient();

    $crawler = $client->request('GET', '/login');

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
