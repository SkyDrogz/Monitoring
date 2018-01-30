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
  public function testConnexion()
  {
    $client = static::createClient([], [
              'PHP_AUTH_USER' => 'Baptiste',
              'PHP_AUTH_PW' => 'admin',
          ]);

         $client->request('GET', '^/login');
         $client->request($httpMethod, $url);
         $this->assertEquals($statusCode, $client->getResponse()->getStatusCode());
     }

        //  $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
  }
