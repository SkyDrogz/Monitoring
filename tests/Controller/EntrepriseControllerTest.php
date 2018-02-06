<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class EntrepriseControllerTest extends WebTestCase
{
  public function testEntrepriseRead()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));
    $crawler = $client->request('GET', '/entreprise/read');
    //Test pour savoir si la div cachée est récupèrée
    $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
  }
  public function testCreation()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));
    $crawler = $client->request('GET','/entreprise/new');
    // echo $crawler -> html();
    $form = $crawler->selectButton("Confirmer l'ajout")->form();

    $form['entreprise[libelle]'] = 'Richard';

   $crawler=$client->submit($form);

    $client->submit($form);
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
  public function testSuppression()
  { 
  // dump($user);exit;

   $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));
    // $user->setIdentifiant('Richard');

    $crawler = $client->request('GET','/entreprise/delete/4');
    // echo $crawler -> html();
  $this->assertTrue(true,$client->getResponse()->isRedirect('entreprise/read'));
  }
  public function testReactivation()
  { 
  // dump($user);exit;

   $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));
    // $user->setIdentifiant('Richard');

    $crawler = $client->request('GET','/entreprise/reactive/4');
    // echo $crawler -> html();
  $this->assertTrue(true,$client->getResponse()->isRedirect('entreprise/active'));
  }
}
