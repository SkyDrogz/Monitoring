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
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));

        $crawler = $client->request('GET', '/system/read');
        //Test pour savoir si la div cachée est récupèrée
        $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    //
    // Test création système
    //
    public function testSystemNew()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));

        $crawler = $client->request('GET', '/system/new');
        // echo $crawler -> html();
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        $form['system[nom]'] = 'Richard';
        $form['system[url]'] = 'Url.url.url';
        $form['system[categSysteme]'] = 2;
        $form['system[user]'] = 3;
        $form['system[niveauUrgence]'] = 1;
        $form['system[repetition]'] = 2;
        $crawler = $client->submit($form);
        
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richard');

        $result = false;
        if($systeme == null ){
            $result = true;
        }     
    $this->assertEquals(true, $result);
    }
    //
    // Test modification des paramètres d'un compte
    //
    public function testSystemeEdit()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richard');
        $crawler = $client->request('GET', '/system/edit/'.$systeme->getId());
        // echo $crawler -> html();
        $form = $crawler->selectButton("Confirmer la modification")->form();

        $form['system[nom]'] = 'Richou';
        $form['system[url]'] = 'url.test.test.com';
        $form['system[categSysteme]'] = 2;
        $form['system[user]'] = 9;
        $form['system[niveauUrgence]'] = 0;
        $form['system[repetition]'] = 51;
        $form['system[requete]'] = null;
        $form['system[resultatAttendu]'] = null;

        $crawler = $client->submit($form);
        $systeme = $this->_em->getRepository(Systeme::class)->findOneById($systeme->getId());
        $result = false;   
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

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');
        $crawler = $client->request('GET', '/system/delete/'. $systeme->getId());
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');        
        $result = false;   
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

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');
        $crawler = $client->request('GET', '/system/reactive/'.$systeme->getId());
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');

        $result = false;   
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

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');
        $crawler = $client->request('GET', '/system/deleteDef/'.$systeme->getId());
        $systeme = $this->_em->getRepository(Systeme::class)->findOneById($systeme->getId());
        $result = false;   
        if($systeme == null){
            $result = true;
        } 
        $this->assertEquals(true , $result);
    }
}
