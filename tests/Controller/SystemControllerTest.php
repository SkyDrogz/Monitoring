<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SystemControllerTest extends WebTestCase
{
  public function testSystemRead()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));

    $crawler = $client->request('GET', '/system/read');

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }
  public function testCreation()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Timothee',
    'PHP_AUTH_PW'   => 'admin',
    ));

    $crawler = $client->request('GET','/system/new');
    // echo $crawler -> html();
    $form = $crawler->selectButton("Confirmer l'ajout")->form();

    $form['system[nom]'] = 'Richard';
    $form['system[url]'] = 'Url.url.url';
    $form['system[categSysteme]'] = 2;
    $form['system[user]'] = 1 ;
    $form['system[niveauUrgence]'] = 1;
    $form['system[repetition]'] = 2;

   $crawler=$client->submit($form);
   $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
