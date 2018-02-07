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
       /**
     * @var EntityManager
     */
    private $_em;
// connection à la BBD
    protected function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        // récuperation de la fonction doctrine
        $this->_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->_em->beginTransaction();
    }
    // exemple d'application pour la fonction
    // $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richard');
    
    //
    // Test consultation des comptes 
    //
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
    //
    // Test d'ajout d'un utilisateur
    //
    public function testUserNew()
    {
     $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => 'Baptiste',
      'PHP_AUTH_PW'   => 'admin',
      ));
      // $user->setIdentifiant('Richard');
      $crawler = $client->request('GET','/user/new');
      // echo $crawler -> html();
      $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richard');
      
      $form = $crawler->selectButton("Confirmer l'ajout")->form();

      $form['user[identifiant]'] = 'Richard';
      $form['user[password]'] = 'admin';
      $form['user[email]'] = 'richard.bod60@gmail.com';
      $form['user[tel]'] = '0680543004';
      $form['user[entreprise]'] = 2;
      $form['user[role]'] = 2;

     $crawler=$client->submit($form);
     if($user !== null ){
      $this->assertTrue(false,$client->getResponse()->isRedirect('user/read'));

    }else{
      $this->assertTrue(true,$client->getResponse()->isRedirect('user/read'));

    }
    }
    //
    // Test modification des paramètres d'un compte
    //
    public function testUserEdit()
      {
       $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'Baptiste',
        'PHP_AUTH_PW'   => 'admin',
        ));
      $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richard');
        
        $crawler = $client->request('GET','/user/edit/'.$user->getId());
        // echo $crawler -> html();
        $form = $crawler->selectButton("Confirmer la modification")->form();

        $form['user[identifiant]'] = 'Richou';
        $form['user[password]'] = 'admin';
        $form['user[email]'] = 'richou.bod60@gmail.com';
        $form['user[tel]'] = '0680543004';
        $form['user[entreprise]'] = 2;
        $form['user[role]'] = 1;

       $crawler=$client->submit($form);
    $this->assertTrue(true,$client->getResponse()->isRedirect('user/new'));
        
      }
      //
      // Test suppression logique d'un compte (passage inactif)
      //
      public function testUserDelete()
      {
      // dump($user);exit;

       $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'Baptiste',
        'PHP_AUTH_PW'   => 'admin',
        ));
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');

        $crawler = $client->request('GET','/user/delete/'.$user->getId());
        // echo $crawler -> html();
      $this->assertTrue(true,$client->getResponse()->isRedirect('user/read'));
      }
      //
      // Test réactivation d'un compte inactif
      //
      public function testUserReactivation()
      {
      // dump($user);exit;

       $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'Baptiste',
        'PHP_AUTH_PW'   => 'admin',
        ));
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');        
        $crawler = $client->request('GET','/user/reactive/'.$user->getId());
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');        
        
        // echo $crawler -> html();if( $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou')== null)
       if ($user->getActif(1))
        {
      $this->assertTrue(true,$client->getResponse()->isRedirect('user/active'));
          
        }else{
      $this->assertTrue(false,$client->getResponse()->isRedirect('user/active'));
        }
      }
      //
      // Test suppression définitive
      //
      public function testDeleteDef()
      {
      // dump($user);exit;

       $client = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'Baptiste',
        'PHP_AUTH_PW'   => 'admin',
        ));
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');

        $crawler = $client->request('GET','/user/delete/'.$user->getId());
        $crawler = $client->request('GET','/user/reactive/'.$user->getId());
        $crawler = $client->request('GET','/user/deleteDef/'.$user->getId());
        if( $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou')== null)
        {
          $this->assertTrue(true,$client->getResponse()->isRedirect('user/read'));
        }else{
      $this->assertTrue(false,$client->getResponse()->isRedirect('user/read'));
          
        }
      }

}
