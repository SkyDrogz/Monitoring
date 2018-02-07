<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EntrepriseControllerTest extends WebTestCase
{
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
        // echo $crawler -> html();
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
        $crawler = $client->request('GET', '/entreprise/edit/4');
        // echo $crawler -> html();
        $form = $crawler->selectButton("Modification")->form();

        $form['entreprise[libelle]'] = 'Richou';

        $crawler = $client->submit($form);

        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    public function testSuppression()
    {
        // dump($user);exit;

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // $user->setIdentifiant('Richard');

        $crawler = $client->request('GET', '/entreprise/delete/4');
        // echo $crawler -> html();
        $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/read'));
    }
    public function testEntrepriseReactivation()
    {
        // dump($user);exit;

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // $user->setIdentifiant('Richard');

        $crawler = $client->request('GET', '/entreprise/reactive/4');
        // echo $crawler -> html();
        $this->assertTrue(true, $client->getResponse()->isRedirect('entreprise/active'));
    }
}
