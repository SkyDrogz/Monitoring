<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Controller\AdminControllerTest;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
  {
    public function testUserRead()
    {
      $client = static::createClient(array(), array(
      'PHP_AUTH_USER' => 'Baptiste',
      'PHP_AUTH_PW'   => 'admin',
      ));

      $crawler = $client->request('GET', '/user/read');
      //Test pour savoir si la div cachée est récupèrée
      $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
}
