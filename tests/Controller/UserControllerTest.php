<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\AdminControllerTest;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager; 
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends WebTestCase
  {
    public function testUserRead()
    {
      $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => 'Baptiste',
      'PHP_AUTH_PW'   => 'admin',
      ));

      $crawler = $client->request('GET', '/user/read');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testCreation()
    { 
      $objectManager = $this->createMock(ObjectManager::class);
      $userRepository = $this->createMock(ObjectRepository::class);
      
     
     
      $userRepository->expects($this->any())
          ->method('find')
          ->willReturn('Richard');
     $objectManager->expects($this->any())
     ->method('getRepository')
     ->willReturn($userRepository);

     $user = new User($objectManager);
     
      $client = static::createClient();
      $user->setIdentifiant('Richard');

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
