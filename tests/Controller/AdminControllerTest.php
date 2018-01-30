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
    $test_user = 'Baptiste';
    $test_password = 'admin';

        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => $test_user,
            'PHP_AUTH_PW'   => $test_password,
        ));

        $this->call('POST','login',$credentials);
        $this->assertResponseOk();
     }
}
