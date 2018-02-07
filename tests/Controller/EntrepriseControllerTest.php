<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
    public function testEntrepriseNew()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $crawler = $client->request('GET', '/entreprise/new');
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        $form['entreprise[libelle]'] = 'Richard';

        $crawler = $client->submit($form);

        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testEdit()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
    $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');
        
        $crawler = $client->request('GET', '/entreprise/edit/'.$entreprise->getLibelle());
        $form = $crawler->selectButton("Modification")->form();

        $form['entreprise[libelle]'] = 'Richou';

        $crawler = $client->submit($form);
         $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        
        $client->submit($form);
        if($entreprise == null)
        {
            $this->assertTrue(False, $client->getResponse()->getStatusCode());
        }else{
            $this->assertTrue(True, $client->getResponse()->getStatusCode());
        }
    }
    public function testSuppression()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        
        $crawler = $client->request('GET', '/entreprise/delete/'.$entreprise->getLibelle());
        if($entreprise->getActif()==false){
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
        }else{
             $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/read'));     
        }
    }
    public function testEntrepriseReactivation()
   {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        
        $crawler = $client->request('GET', '/entreprise/reactive/'.$entreprise->getLibelle());
        if($entreprise->getActif()==true){
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
        }else{
             $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/read'));     
        }
    }
    public function testDeleteDef()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByIdentifiant('Richou');
        $crawler = $client->request('GET', '/entreprise/deleteDef/' . $entreprise->getId());
        $entreprise = $this->_em->clear();
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByIdentifiant('Richou');

        if ($entreprise == null) {
            $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/active'));
        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('entreprise/active'));
        }
    }
}
