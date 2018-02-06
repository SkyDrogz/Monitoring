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
      //Test pour savoir si la div cachée est récupèrée
      $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    public function testCreation()
    { 
    //   $objectManager = $this->createMock(ObjectManager::class);
    //   $userRepository = $this->createMock(ObjectRepository::class);
      
     
    //   $user = new User();
    //   $user->setIdentifiant('Richard');
     
    //   $userRepository->expects($this->any())
    //       ->method('find')
    //       ->willReturn($user);
          
    //  $objectManager->expects($this->any())
    //  ->method('getRepository')
    //  ->willReturn($userRepository);

    // dump($user);exit;

     $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => 'Baptiste',
      'PHP_AUTH_PW'   => 'admin',
      ));
      // $user->setIdentifiant('Richard');

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
