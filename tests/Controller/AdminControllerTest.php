<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminControllerTest extends WebTestCase
{
    public function testConnexionAdmin()
    {
      // Création d'un client
        $client = static::createClient();
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        // Création d'un token avec un utilisateur ADMIN
        $token = new UsernamePasswordToken('Baptiste', 'admin', $firewallContext, array('ROLE_SUPER_ADMIN'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        // Création d'un cookie avec le nom et l'id de la session
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        // Récupération de la page login
        $crawler = $client->request('GET', '/login');

        // Bouton submit du formulaire
        $form = $crawler->selectButton('Connexion')->form();

        // Paramètre du formulaire
        $form['_username'] = 'Baptiste';
        $form['_password'] = 'admin';

        // Submit du formulaire
        $crawler = $client->submit($form);

        // Suivre la redirection du crawler
        $crawler = $client->followRedirect();
        // S'il trouve la div caché dans la base uniquement visible en tant qu'ADMIN, le test est OK
        $this->assertSame(1, $crawler->filter('div.TestRoleADMIN')->count());
    }
    public function testConnexionUser()
    {
        // Création d'un client
        $client = static::createClient();
        // Récupèration de la session
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'secured_area';

        // Création d'un token avec un utilisateur USER
        $token = new UsernamePasswordToken('Timothee', 'admin', $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        //Création d'un cookie avec le nom de session et l'id
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        // Récupèration de la page de login
        $crawler = $client->request('GET', '/login');

        // Bouton submit du formulaire
        $form = $crawler->selectButton('Connexion')->form();

        // Paramètres du formulaire
        $form['_username'] = 'Timothee';
        $form['_password'] = 'admin';

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
        // S'il trouve la div caché dans la base uniquement visible en tant qu'USER, le test est OK
        $this->assertSame(1, $crawler->filter('div.TestRoleUSER')->count());
    }
    public function testDeconnexion()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));

        // Aller à la page de déconnexion
        $crawler = $client->request('GET', '/deconnexion');
        // S'il redirige bien à la page login, le test est OK
        $this->assertSame(1, $crawler->filter('html:contains("Redirecting to /login")')->count());
    }
}
