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
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richard');
        $form = $crawler->selectButton("Confirmer l'ajout")->form();

        $form['system[nom]'] = 'Richard';
        $form['system[url]'] = 'Url.url.url';
        $form['system[categSysteme]'] = 2;
        $form['system[user]'] = 3;
        $form['system[niveauUrgence]'] = 1;
        $form['system[repetition]'] = 2;

        if ($systeme !== null) {
            $this->assertTrue(false, $client->getResponse()->isRedirect('/system/new'));
        } else {
            $crawler = $client->submit($form);
            $this->assertTrue(true, $client->getResponse()->isRedirect('/system/new'));
        }
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

        $crawler = $client->request('GET', '/system/edit/' . $systeme->getId());
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
        if ($systeme->getNom() == "Richou") {
            $this->assertTrue(true, $client->getResponse()->isRedirect('system/read'));
        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('system/read'));

        }

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
        $crawler = $client->request('GET', '/system/delete/' . $systeme->getId());
        $this->assertTrue(true, $client->getResponse()->isRedirect('system/read'));
    }
    //
    // Test réactivation d'un compte inactif
    //

    public function testUserReactivation()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');
        $crawler = $client->request('GET', '/system/reactive/' . $systeme->getId());
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');

        if ($systeme->getActif() == true) {
            $this->assertTrue(true, $client->getResponse()->isRedirect('system/active'));

        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('system/active'));
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
        $systeme = $this->_em->getRepository(Systeme::class)->findOneByNomSysteme('Richou');
        $crawler = $client->request('GET', '/system/deleteDef/' . $systeme->getId());
        $systeme = $this->_em->getRepository(Systeme::class)->findOneById($systeme->getId());
        if ($systeme == null) {
            $this->assertTrue(true, $client->getResponse()->isRedirect('system/read'));
        } else {
            $this->assertTrue(false, $client->getResponse()->isRedirect('system/read'));

        }
    }
}
