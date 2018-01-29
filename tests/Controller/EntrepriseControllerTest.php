<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EntrepriseControllerTest extends WebTestCase
{
  public function testEntrepriseConsultation()
  {
    $client = static::createClient();

    $crawler = $client->request('GET', '/entreprise/consultation');

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
}
