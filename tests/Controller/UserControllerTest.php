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
    public function testUserRead()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/user/read');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testCreation()
    {
      $client = static::createClient();

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

     if($this->getDoctrine()->getRepository(User::class)->findOneByIdentifiant('Richard')!== null)
     {
       $this->assertEquals(302, $client->getResponse()->getStatusCode());
     }
  }
}
