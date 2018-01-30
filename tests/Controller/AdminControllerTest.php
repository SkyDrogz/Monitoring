<?php
namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


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
  public function testConnexionAdmin()
  {
    $client = static::createClient();

    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('Connexion')->form();
    $form['_username'] = 'Baptiste';
    $form['_password'] = 'admin';

    $crawler =$client->submit($form);
    $crawler =$client->followRedirect();
    $this->assertSame(1, $crawler->filter('div.97TIM98BAT')->count());
  }
  public function testConnexionUser()
  {
    $client = static::createClient();

    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('Connexion')->form();
    $form['_username'] = 'Timothee';
    $form['_password'] = 'admin';

    $crawler =$client->submit($form);
    $crawler =$client->followRedirect();
    $this->assertSame(1, $crawler->filter('div.USER')->count());
  }

  // public function testDeconnexion()
  //     {
  //       $user = $this->getUser();
  //       $date = date_create(date("Y-m-d H:i:s"));
  //       $date = new \Datetime();
  //       $em = $this->getDoctrine()->getManager();
  //       $user->setDateDeconnexion($date);
  //       $em->persist($user);
  //       $client = static::createClient();
  //       $crawler = $client->request('GET','/deconnexion');
  //       $crawler = $client->followRedirect();
  //       $this->assertSame(
  //           1,
  //           $crawler->filter('html:contains("Connexion")')->count()
  //       );
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
