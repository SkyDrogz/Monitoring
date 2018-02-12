<?php
namespace App\Tests\Controller;

use App\Entity\Systeme;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SystemControllerTest extends WebTestCase
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
    // $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richard');

    //
    // Test consultation système
    //
    public function testSystemRead()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de la page de consultation
        $crawler = $client->request('GET', '/system/read');
        //Test pour savoir si la div cachée est récupèrée
        $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    //
    // Test création système
    //
    public function testSystemNew()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de la page d'ajout d'un système
        $crawler = $client->request('GET', '/system/new');
        // Bouton submit du formulaire
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        // Paramètres du formulaire
        $form['system[nom]'] = 'Cora';
        $form['system[url]'] = 'https://www.cora.fr';
        $form['system[categSysteme]'] = 3;
        $form['system[user]'] = 3;
        $form['system[niveauUrgence]'] = 0;
        $form['system[repetition]'] = 5;
        $crawler = $client->submit($form);

        // Test pour savoir si le système est déjà dans la base de données
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Cora');

        $result = false;
        // Si aucun système n'est trouvé, nous renvoyons TRUE et le test est fonctionnel
        if($systeme->getNom() == 'Cora' ){
            $result = true;
        }
    $this->assertEquals(true, $result);
    }
    //
    // Test modification des paramètres d'un compte
    //
    public function testSystemeEdit()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération du système nommée "Richard"
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('EDF');
        // Récupération de la page de modification des systèmes
        $crawler = $client->request('GET', '/system/edit/'.$systeme->getId());
        // Submit du formulaire
        $form = $crawler->selectButton("Confirmer la modification")->form();

        // Paramètres du formulaire
        $form['system[nom]'] = 'Richou';
        $form['system[url]'] = 'url.test.test.com';
        $form['system[categSysteme]'] = 2;
        $form['system[user]'] = 2;
        $form['system[niveauUrgence]'] = 0;
        $form['system[repetition]'] = 51;
        $form['system[requete]'] = null;
        $form['system[resultatAttendu]'] = null;

        // Submit du formulaire dans le crawler
        $crawler = $client->submit($form);

        // Actualisation de la BDD
        $this->setUp();

        // Récupération du système avec l'id
        $systeme = $this->_em->getRepository(Systeme::class)->findOneById($systeme->getId());
        $result = false;
        // Si le système est trouvé = test réussi
        if($systeme->getNom() == true){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
    //
    // Test suppression logique d'un compte (passage inactif)
    //
    public function testSystemeDelete()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération du système nommé Richou
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Facebook');
        // Récupération de la page delete avec l'id du système passé en paramètre
        $crawler = $client->request('GET', '/system/delete/'. $systeme->getId());

        // Actualisation de la BDD
        $this->setUp();

        // Tentative de récupération du système nommé Richou
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Facebook');
        $result = false;
        // Si le système est non actif, il a bien été supprimé de manière logique, le test est donc fonctionnel
        if($systeme->getActif() == false){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
    //
    // Test réactivation d'un compte inactif (passage actif)
    //

    public function testReactivation()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération du système Richou
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Norauto');
        // Récupération de la page reactive avec l'id du système passé en paramètre
        $crawler = $client->request('GET', '/system/reactive/'.$systeme->getId());

        // Actualisation de la BDD
        $this->setUp();

        // Récupération du système Richou
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');

        $result = false;
        // Si le système est actif, le test est fonctionnel
        if($systeme->getActif() == true){
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
        // Récupération du système nommé Richou
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Priceminister');
        // Récupération de la page deleteDef avec l'id du système passé en paramètre
        $crawler = $client->request('GET', '/system/deleteDef/'.$systeme->getId());

        // Actualisation de la BDD
        $this->setUp();

        // Tentative de récupération du système avec l'id
        $systeme = $this->_em->getRepository(Systeme::class)->findOneById($systeme->getId());
        $result = false;
        // Si le système n'a pas été trouvé, cela confirmeras sa suppression, le test est donc OK
        if($systeme == null){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
}
