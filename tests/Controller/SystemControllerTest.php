<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SystemControllerTest extends WebTestCase
{
  public function testSystemConsultation()
  {
    $client = static::createClient();

    $crawler = $client->request('GET', '/system/consultation');

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
