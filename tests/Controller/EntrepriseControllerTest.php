<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EntrepriseControllerTest extends WebTestCase
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
    // $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');

    //
    // Test consultation entreprise
    //
    public function testEntrepriseRead()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $crawler = $client->request('GET', '/entreprise/read');
        //Test pour savoir si la div cachée est récupèrée
        $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    //
    // Test création d'une entreprise
    //
    public function testEntrepriseNew()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');        
        $crawler = $client->request('GET', '/entreprise/new');
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        $form['entreprise[libelle]'] = 'Richard';

        $crawler = $client->submit($form);

        if($entreprise == null){
        $this->assertTrue(true, $client->getResponse()->getStatusCode());            
        }else{
        $this->assertTrue(false, $client->getResponse()->getStatusCode());            
        }
    }
    //
    // Test de modification d'entreprise (passage inactif)
    //
    public function testEntrepriseEdit()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');

        $crawler = $client->request('GET', '/entreprise/edit/'.$entreprise->getId());
        
        // echo $crawler -> html();
        $form = $crawler->selectButton("Modification")->form();

        $form['entreprise[libelle]'] = 'Richou';
        $crawler = $client->submit($form);
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());

        if ($entreprise->getLibelle() == "Richou") {
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/read'));

        }

    }
    //
    // Test de suppression logique d'une entreprise
    //
    public function testSuppression()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');     
        $crawler = $client->request('GET', '/entreprise/delete/'.$entreprise->getId());
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());        
        if($entreprise->getActif()==false){
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
        }else{
             $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/read'));     
        }
    }
    //
    //  Test de reaction d'une entreprise (passage actif)
    //  
    public function testEntrepriseReactivation()
   {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        $crawler = $client->request('GET', '/entreprise/reactive/'.$entreprise->getId());
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());        
        if($entreprise->getActif()==true){
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
        }else{
             $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/read'));     
        }
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
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        $crawler = $client->request('GET', '/entreprise/deleteDef/'.$entreprise->getId());
        $entreprise = $this->_em->clear();
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');

        if ($entreprise == null) {
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/active'));
        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/active'));
        }
    }
}
