<?php
namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class AdminControllerTest extends WebTestCase
{

  // public function testLoginPage()
  // {
  //   $client = static::createClient();
  //   $client->request('GET', '/login');

  //   $this->assertEquals(200, $client->getResponse()->getStatusCode());
  // }


  // public function testConnexion()
  // {
  //   $client = static::createClient();

  //   $crawler = $client->request('GET','/login');

  //   $form = $crawler->selectButton('Connexion')->form();
  //   $form['_username'] = 'admin';
  //   $form['_password'] = 'admin';

  //   $client->submit($form);
  //   $client->followRedirect();
  //   $this->assertEquals(200, $client->getResponse()->getStatusCode());
  // }
<<<<<<< HEAD
  // public function testConnexionAdmin()
  // {
  //   $client = static::createClient();

  //   $crawler = $client->request('GET','/login');

  //   $form = $crawler->selectButton('Connexion')->form();
  //   $form['_username'] = 'admin';
  //   $form['_password'] = 'admin';

  //   $crawler =$client->submit($form);
  //   $crawler =$client->followRedirect();
  //   $this->assertSame(1, $crawler->filter('div.TestRoleADMIN')->count());
  // }
  // public function testConnexionUser()
  // {
  //   $client = static::createClient();

  //   $crawler = $client->request('GET','/login');

  //   $form = $crawler->selectButton('Connexion')->form();
  //   $form['_username'] = 'Baptiste';
  //   $form['_password'] = 'admin';

  //   $crawler =$client->submit($form);
  //   $crawler =$client->followRedirect();
  //   $this->assertSame(1, $crawler->filter('div.TestRoleUSER')->count());
  // }
=======
  public function testConnexionAdmin()
  {
    $client = static::createClient();
    $session = $client->getContainer()->get('session');

    // the firewall context defaults to the firewall name
    $firewallContext = 'secured_area';

    $token = new UsernamePasswordToken('Baptiste', 'admin', $firewallContext, array('ROLE_SUPER_ADMIN'));
    $session->set('_security_'.$firewallContext, serialize($token));
    $session->save();

    $cookie = new Cookie($session->getName(), $session->getId());
    $client->getCookieJar()->set($cookie);
    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('Connexion')->form();
    $form['_username'] = 'Baptiste';
    $form['_password'] = 'admin';

    $crawler =$client->submit($form);
    $crawler =$client->followRedirect();
    $this->assertSame(1, $crawler->filter('div.TestRoleADMIN')->count());
  }
  public function testConnexionUser()
  {
    $client = static::createClient();
    $session = $client->getContainer()->get('session');

    // the firewall context defaults to the firewall name
    $firewallContext = 'secured_area';

    $token = new UsernamePasswordToken('Timothee', 'admin', $firewallContext, array('ROLE_ADMIN'));
    $session->set('_security_'.$firewallContext, serialize($token));
    $session->save();

    $cookie = new Cookie($session->getName(), $session->getId());
    $client->getCookieJar()->set($cookie);
    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('Connexion')->form();
    $form['_username'] = 'Timothee';
    $form['_password'] = 'admin';

    $crawler =$client->submit($form);
    $crawler =$client->followRedirect();
    $this->assertSame(1, $crawler->filter('div.TestRoleUSER')->count());
  }
>>>>>>> 3936e37915b0cff84361bbab857af2f14abeb412
  // public function testDeconnexion()
  //     {
  //       $client = static::createClient(array(), array(
  //       'PHP_AUTH_USER' => 'Baptiste',
  //       'PHP_AUTH_PW'   => 'admin',
  //       ));
  //
  //       $crawler = $client->request('GET', '/deconnexion');
  //
  //       $this->assertEquals(200, $client->getResponse()->getStatusCode());
  //      }
      // public function testRedirectLogin()
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
      //   $this->assertSame(1, $crawler->filter('pwd-container')->count());
      //  }
}
