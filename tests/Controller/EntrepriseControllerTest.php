<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EntrepriseControllerTest extends WebTestCase
{
  public function testEntrepriseRead()
  {
    $this->logIn();

    $crawler = $client->request('GET', '/entreprise/read');

    $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
  }
  public function testCreation()
  {
    $client = static::createClient();
    $this->logIn();
    $crawler = $this->$client->request('GET','/entreprise/new');

    // echo $crawler -> html();
    $form = $crawler->selectButton("Confirmer l'ajout")->form();

    $form['entreprise[libelle]'] = 'Richard';

   $crawler=$client->submit($form);




    $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
