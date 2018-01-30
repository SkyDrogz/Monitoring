<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


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
    $test_user = 'admin';
    $test_password = 'admin';

        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => $test_user,
            'PHP_AUTH_PW'   => $test_password,
        ));

        $this->call('POST','login',$credentials);
        $this->assertResponseOk();
     }
}
