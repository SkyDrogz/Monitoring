<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
  public function testLoginPage()
  {
    $client = static::createClient();
    $client->request('GET', '/login');

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
  }


  public function testConnexion()
  {

    $client = static::createClient();

    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('Connexion')->form();
    $form['_username'] = 'Baptiste';
    $form['_password'] = 'admin';

    $client->submit($form);
    $client->followRedirect();
         $this->assertEquals(200, $client->getResponse()->getStatusCode());
     }

     // public function testConnexion()
     // {
     //
     //   $client = static::createClient();
     //
     //   $crawler = $client->request('GET','/login');
     //
     //   $form = $crawler->selectButton('Connexion')->form();
     //   $form['_username'] = 'Baptiste';
     //   $form['_password'] = 'admin';
     //
     //   $client->submit($form);
     //   $client->followRedirect();
     //   $this->assertEquals(200, $client->getResponse()->getStatusCode());
     //  }

      public function testDeconnexion()
      {

        $client = static::createClient();

        $crawler = $client->request('GET','/deconnexion');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
       }

      public function testRedirectLogin()
      {

        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Connexion')->form();
        $form['_username'] = 'Baptiste';
        $form['_password'] = 'admin';

        $client->submit($form);
        $client->followRedirect();
        $this->assertSame(1, $crawler->filter('pwd-container')->count());
       }
}
