<?php
namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de la page de consultation
        $crawler = $client->request('GET', '/user/read');
        //Test pour savoir si la div cachée est récupèrée
        $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    //
    // Test de création'ajout d'un utilisateur
    //
    public function testUserNew()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de la page d'ajout d'un utilisateur
        $crawler = $client->request('GET', '/user/new');

        // Bouton submit du formulaire
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        // Paramètres du formulaire
        $form['user[identifiant]'] = 'Richard';
        $form['user[password]'] = 'admin';
        $form['user[email]'] = 'richard.bod60@gmail.com';
        $form['user[tel]'] = '0680543004';
        $form['user[entreprise]'] = 2;
        $form['user[role]'] = 2;

        // Submit du formulaire
        $crawler = $client->submit($form);
        // Tentative de récupération de l'user Richard
        $user = $this->_em->getRepository(User::class)->findOneById('Richard');
        $result = false;
        // Si l'user n'est pas trouvé, l'ajout peux donc se faire, le test est OK
        if($user == null){
            $result = true;
        }
        $this->assertEquals(true , $result);

    }
    //
    // Test modification des paramètres d'un utilisateur
    //
    public function testUserEdit()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'utilisateur nommé Richard
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richard');

        // Récupération de la page de modification avec l'id passé en paramètre
        $crawler = $client->request('GET', '/user/edit/'.$user->getId());
        // Bouton submit du formulaire
        $form = $crawler->selectButton("Confirmer la modification")->form();

        // Paramètres du formulaire
        $form['user[identifiant]'] = 'Richou';
        $form['user[password]'] = 'admin';
        $form['user[email]'] = 'richou.bod60@gmail.com';
        $form['user[tel]'] = '0680543004';
        $form['user[entreprise]'] = 2;
        $form['user[role]'] = 1;

        // Submit du formulaire au crawler
        $crawler = $client->submit($form);

        // Récupération de l'utilisateur
        $user = $this->_em->getRepository(User::class)->findOneById($user->getId());

        //Initialisation du résultat à FALSE
        $result = false;

        // Si l'utilisateur s'est bien renommé en Richou, le test est OK
        if($user->getIdentifiant() == "Richou"){
            $result = true;
        }
        $this->assertEquals(true , $result);

    }
    //
    // Test suppression logique d'un compte (passage inactif)
    //
    public function testUserDelete()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'utilisateur nommé Richou
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');

        // Récupération de la page de delete avec l'id passé en paramètres
        $crawler = $client->request('GET', '/user/delete/' . $user->getId());
        // Tentative de récupération de l'utilisateur avec l'id
        $user = $this->_em->getRepository(User::class)->findOneById($user->getId());
        $result = false;
        // Si l'utilisateur est inactif, le test est OK
        if($user->getActif() == false){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
    //
    // Test réactivation d'un compte inactif (passage actif)
    //
    public function testUserReactivation()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'identifiant nommé Richou
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');
        // Récupération de la page de reactive avec l'id de l'user passé en paramètre
        $crawler = $client->request('GET', '/user/reactive/'.$user->getId());
        // Récupération de l'user
        $user = $this->_em->getRepository(User::class)->findOneById($user->getId());
        $result = false;
        // Si l'utilisateur est actif, il a bien été réactivé et le test est OK
        if($user->getActif() == true){
            $result = true;
        }
        $this->assertEquals(true , $result);

    }
    //
    // Test suppression définitive
    //
    public function testDeleteDef()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'user nommé Richou
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');
        // Récupération de la page deleteDef avec l'id passé en paramètre
        $crawler = $client->request('GET', '/user/deleteDef/'.$user->getId());
        // Suppression de l'utilisateur
        $user = $this->_em->clear();
        // Récupération de l'utilisateur nommé Richou
        $user = $this->_em->getRepository(User::class)->findOneByIdentifiant('Richou');
        $result = false;
        // Si l'utilisateur est null le test s'est bien passé et à donc bien supprimé l'utilisateur
        if($user == null){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
}
