<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\AdminControllerTest;
use App\Entity\User;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
   private $client = null;

   public function setUp()
   {
     $client = static::createClient(array(), array(
       'PHP_AUTH_USER' => 'Baptiste',
       'PHP_AUTH_PW'   => 'admin',
     ));
   }
   private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('Baptiste', 'admin', $firewallContext, array('ROLE_SUPER_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    public function testUserRead()
    {
      $this->logIn();

      $crawler = $client->request('GET', '/user/read');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testCreation()
    {
      $this->logIn();

      $crawler = $client->request('GET','/user/new');
      // echo $crawler -> html();
      $form = $crawler->selectButton("Confirmer l'ajout")->form();

      $form['user[identifiant]'] = 'Richard';
      $form['user[password]'] = 'admin';
      $form['user[email]'] = 'richard.bod60@gmail.com';
      $form['user[tel]'] = '0680543004';
      $form['user[entreprise]'] = 2;
      $form['user[role]'] = 2;


     $crawler=$client->submit($form);


      $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
