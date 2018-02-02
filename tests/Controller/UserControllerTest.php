<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\AdminControllerTest;
class UserControllerTest extends WebTestCase
{
    // public function testUserConsultation()
    // {
    //   $client = static::createClient();
    //
    //   $crawler = $client->request('GET', '/user/consultation');
    //
    //   $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // }
    // public function testCreation()
    // {
    //   $client = static::createClient();
    //
    //   $crawler = $client->request('GET','/user/new');
    //   $form = $crawler->selectButton("Confirmer l'ajout")->form();
    //
    //   $form['user[identifiant]'] = 'Richard';
    //   $form['user[password]'] = 'admin';
    //   $form['user[email]'] = 'richard.bod60@gmail.com';
    //   $form['user[tel]'] = '0680543004';
    //   $form['user[entreprise]'] = 2;
    //   $form['user[role]'] = 2;
    //
    //
    //  $crawler=$client->submit($form);
    //
    //
    //   $this->assertEquals(200, $crawler->getResponse()->getStatusCode());
    // }
}
