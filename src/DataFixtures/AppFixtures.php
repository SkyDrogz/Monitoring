<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Systeme;
use App\Entity\CategSysteme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setIdentifiant('Richelieu');
        $user->setPassword('test');
        $plainPassword = $user->getPassword();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setEmail("Riche@lieu.com");
        $user->setTel('0349504');
        $user->setActif(1);
        $manager->persist($user);
        $manager->flush();


        // CategSysteme Serveur
        $categSysteme1 = new CategSysteme();
        $categSysteme1->setCategorie('Serveur');
        $manager->persist($categSysteme1);
        $manager->flush();
        // CategSysteme API
        $categSysteme2 = new CategSysteme();
        $categSysteme2->setCategorie('API');
        $manager->persist($categSysteme2);
        $manager->flush();
        // CategSysteme Serveur
        $categSysteme3 = new CategSysteme();
        $categSysteme3->setCategorie('Site internet');
        $manager->persist($categSysteme3);
        $manager->flush();
        // System new
        $system = new Systeme();
        $system->setNom('EDF');
        $system->setUrl("https://www.edf.fr/groupe-edf");
        $system->setCategSysteme($categSysteme3);
        $system->setActif(1);
        $system->setUser($user);
        $system->setRepetition(5);
        $system->setNiveauUrgence(0);
        $manager->persist($system);
        $manager->flush();
        // System edit
        $system = new Systeme();
        $system->setNom('Richard');
        $system->setUrl("https://www.url.com");
        $system->setCategSysteme($categSysteme3);
        $system->setActif(1);
        $system->setUser($user);
        $system->setRepetition(5);
        $system->setNiveauUrgence(0);
        $manager->persist($system);
        $manager->flush();
    }
}
?>
