<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserConsultation()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/user/consultation');

      $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testCreation()
    {
      $client = static::createClient();
    
      $crawler = $client->request('GET','/user/new');

      $form = $crawler->selectButton("form[save]")->form();
     
      $form['identifiant'] = 'Richard';
      $form['password'] = 'admin';
      $form['email'] = 'richard.bod60@gmail.com';
      $form['tel'] = '0680543004';
      $form['entreprise'] = 1;
      $form['role'] = 2;
      

     $crawler=$client->submit($form);
      

      $this->assertEquals(200, $crawler->getResponse()->getStatusCode());
    }
}
