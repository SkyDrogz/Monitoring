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
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de la page entreprise/read
        $crawler = $client->request('GET', '/entreprise/read');
        //Test pour savoir si la div cachée est récupèrée
        $this->assertSame(1, $crawler->filter('html:contains("testRead")')->count());
    }
    //
    // Test création d'une entreprise
    //
    public function testEntrepriseNew()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
            // Récupération de la page entreprise/new
            $crawler = $client->request('GET', '/entreprise/new');

            // Au clique sur le bouton, les entreprises ci-dessous seront saisite
            $form = $crawler->selectButton("Confirmer l'ajout")->form();

            // Saisie des données
            $form['entreprise[libelle]'] = 'Richard';

            // Soumission du formulaire
            $crawler = $client->submit($form);

            // Tentative de récupération de l'entreprise nommée "Richard"
            $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');

            $result = false;
            // Si l'entreprise n'est pas trouvé, variable result se verras attribuer TRUE, sinon FALSE
            if($entreprise == null ){
                $result = true;
            }
            // Si l'entreprise n'est pas encore dans la BDD, le test est fonctionnel
        $this->assertEquals(true, $result);

    }
    //
    // Test de modification d'entreprise (passage inactif)
    //
    public function testEntrepriseEdit()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Tentative de récupération de l'entreprise nommée "Richard"
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richard');

        // Récupération de la page de modification de l'entreprise
        $crawler = $client->request('GET', '/entreprise/edit/'.$entreprise->getId());

        // echo $crawler -> html();
        // Au clique sur le bouton Modification, le formulaire avec les infos saisies sont transmises
        $form = $crawler->selectButton("Modification")->form();

        $form['entreprise[libelle]'] = 'Richou';
        // Soumission du formulaire
        $crawler = $client->submit($form);
        // Récupération de l'id de l'entreprise
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());
        $result = false;
        // Si le libelle récupéré est similaire aux informations passés dans le formulaire, le test est correct
        if ($entreprise->getLibelle() == "Richou"){
            $result = true;
        }
        $this->assertEquals(true , $result);


    }
    //
    // Test de suppression logique d'une entreprise
    //
    public function testSuppression()
    {
      // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'entreprise nommée 'Richou'
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        // Récupération de la page Delete avec l'id récupéré auparavant
        $crawler = $client->request('GET', '/entreprise/delete/'.$entreprise->getId());
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());
        $result = false;
        // Si l'entreprise est non active, nous pouvons la supprimée et le test est fonctionnel
        if($entreprise->getActif() == false){
            $result = true;
        }
        $this->assertEquals(true , $result);

    }
    //
    //  Test de reaction d'une entreprise (passage actif)
    //
    public function testEntrepriseReactivation()
   {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'entreprise
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        // Récupération de la page reactive avec l'id passée en paramètre dans le crawler
        $crawler = $client->request('GET', '/entreprise/reactive/'.$entreprise->getId());
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneById($entreprise->getId());
        $result = false;
        // Si l'entreprise est active, nous pouvons la réactiver
        if($entreprise->getActif() == true){
            $result = true;
        }
        $this->assertEquals(true , $result);

    }
    //
    // Test suppression définitive
    //
    public function testDeleteDef()
    {
        // Connexion à un compte Admin
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'Baptiste',
            'PHP_AUTH_PW' => 'admin',
        ));
        // Récupération de l'entreprise "Richou"
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        // Récupération de la page deleteDef avec l'id de l'entreprise passée en paramètre
        $crawler = $client->request('GET', '/entreprise/deleteDef/'.$entreprise->getId());
        // Suppression de l'entreprise
        $entreprise = $this->_em->clear();
        // Tentative de récupération de l'entreprise "Richou"
        $entreprise = $this->_em->getRepository(Entreprise::class)->findOneByLibelle('Richou');
        $result = false;
        // Si la tentative a échoué elle renverras null, la suppression sera donc bien effectuée
        if($entreprise == null){
            $result = true;
        }
        $this->assertEquals(true , $result);
    }
}
