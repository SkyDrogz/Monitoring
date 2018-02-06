<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Client as BaseClient;
use Symfony\Component\BrowserKit\Response;

class SystemControllerTest extends WebTestCase
{
  public function testSystemRead()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));

    $crawler = $client->request('GET', '/system/read');
    //Test pour savoir si la div cachée est récupèrée
    $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
  }
  public function testSystemCreate()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));

    $crawler = $client->request('GET','/system/new');
    // echo $crawler -> html();
    $form = $crawler->selectButton("Confirmer l'ajout")->form();

    $form['system[nom]'] = 'Richard';
    $form['system[url]'] = 'Url.url.url';
    $form['system[categSysteme]'] = 2;
    $form['system[user]'] = 1 ;
    $form['system[niveauUrgence]'] = 1;
    $form['system[repetition]'] = 2;

   $crawler=$client->submit($form);
   $this->assertTrue($client->getResponse()->isRedirect('/system/new'));
 }
  public function testSystemeDelete()
  {
    $client = static::createClient(array(), array(
    'PHP_AUTH_USER' => 'Baptiste',
    'PHP_AUTH_PW'   => 'admin',
    ));

    $crawler = $client->request('GET','/system/read');
    $link = $crawler->selectLink(' ')->link();
    $client->click($link);
    dump($client);exit;
    $this->assertEquals(302, $client->getResponse()->getStatusCode());
  }
}
