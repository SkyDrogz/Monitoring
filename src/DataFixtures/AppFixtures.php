systemReactive<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\CategSysteme;
use App\Entity\Systeme;
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
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setEmail("Riche@lieu.com");
        $user->setTel('0349504');
        $user->setActif(1);
        $manager->persist($user);
        $manager->flush();

        // ------------------------ CategSystem ------------------------------//

        // CategSystem API
        $categSysteme1 = new CategSysteme();
        $categSysteme1->setId(1);
        $categSysteme1->setCategorie('API');
        $manager->persist($categSysteme1);
        $manager->flush();
        // CategSystem Serveur
        $categSysteme2 = new CategSysteme();
        $categSysteme2->setId(2);
        $categSysteme2->setCategorie('Serveur');
        $manager->persist($categSysteme2);
        $manager->flush();
        // CategSystem
        $categSysteme3 = new CategSysteme();
        $categSysteme3->setId(3);
        $categSysteme3->setCategorie('Site internet');
        $manager->persist($categSysteme3);
        $manager->flush();

        // ---------------------------- Systeme -----------------------------//

        // Ajout Systeme (Je ne sais pas si l'ajout est nécéssaire dans les fixtures vu que le test l'ajoute lui-même)
        $systemAdd = new Systeme();
        $systemAdd->setId(1);
        $systemAdd->setCategSysteme($categSysteme3);
        $systemAdd->setUser($user1);
        $systemAdd->setNom("EDF");
        $systemAdd->setURL('https://www.edf.fr/');
        $systemAdd->setActif(1);
        $systemAdd->setRepetition(5);
        $systemAdd->setNiveauUrgence(0);
        $manager->persist($systemAdd);
        $manager->flush();

        // Modification Systeme
        $systemEdit = new Systeme();
        $systemAdd->setId(2);
        $systemEdit->setCategSysteme($categSysteme3);
        $systemEdit->setUser($user1);
        $systemEdit->setNom("Facebook");
        $systemEdit->setURL('https://www.facebook.com/');
        $systemEdit->setActif(1);
        $systemEdit->setRepetition(5);
        $systemEdit->setNiveauUrgence(0);
        $manager->persist($systemEdit);
        $manager->flush();

        // Suppression logique Systeme
        $systemDelete = new Systeme();
        $systemAdd->setId(3);
        $systemDelete->setCategSysteme($categSysteme3);
        $systemDelete->setUser($user1);
        $systemDelete->setNom("Google");
        $systemDelete->setURL('https://www.google.fr/');
        $systemDelete->setActif(1);
        $systemDelete->setRepetition(5);
        $systemDelete->setNiveauUrgence(0);
        $manager->persist($systemDelete);
        $manager->flush();

        // Reactivation Systeme
        $systemReactive = new Systeme();
        $systemAdd->setId(4);
        $systemReactive->setCategSysteme($categSysteme3);
        $systemReactive->setUser($user1);
        $systemReactive->setNom("Priceminister");
        $systemReactive->setURL('http://www.priceminister.com/');
        $systemReactive->setActif(0);
        $systemReactive->setRepetition(5);
        $systemReactive->setNiveauUrgence(0);
        $manager->persist($systemReactive);
        $manager->flush();

        // Suppression définitive Systeme
        $systemDeleteDef = new Systeme();
        $systemDeleteDef->setCategSysteme($categSysteme3);
        $systemDeleteDef->setUser($user1);
        $systemDeleteDef->setNom("Norauto");
        $systemDeleteDef->setURL('https://www.norauto.fr/');
        $systemDeleteDef->setActif(0);
        $systemDeleteDef->setRepetition(5);
        $systemDeleteDef->setNiveauUrgence(0);
        $manager->persist($systemDeleteDef);
        $manager->flush();

        // -------------------------- Entreprise -----------------------------//

        // Ajout entreprise (Je ne sais pas si l'ajout est nécéssaire dans les fixtures vu que le test l'ajoute lui-même)
        $entrepriseAdd = new Entreprise();
        $entrepriseAdd->setId(1);
        $entrepriseAdd->setLibelle("EDF");
        $entrepriseAdd->setActif(1);
        $manager->persist($entrepriseAdd);
        $manager->flush();

        // Modification entreprise
        $entrepriseEdit = new Entreprise();
        $entrepriseEdit->setId(2);
        $entrepriseEdit->setLibelle("Facebook");
        $entrepriseAdd->setActif(1);
        $manager->persist($entrepriseEdit);
        $manager->flush();

        // Suppression logique entreprise
        $entrepriseDelete = new Entreprise();
        $entrepriseDelete->setId(3);
        $entrepriseDelete->setLibelle("Google");
        $entrepriseDelete->setActif(1);
        $manager->persist($entrepriseDelete);
        $manager->flush();

        // Réactivation entreprise
        $entrepriseReactivation = new Entreprise();
        $entrepriseReactivation->setId(4);
        $entrepriseReactivation->setLibelle("Priceminister");
        $entrepriseAdd->setActif(0);
        $manager->persist($entrepriseReactivation);
        $manager->flush();

        // Suppression définitive entreprise
        $entrepriseDeleteDef = new Entreprise();
        $entrepriseDeleteDef->setId(5);
        $entrepriseDeleteDef->setLibelle("Norauto");
        $entrepriseAdd->setActif(0);
        $manager->persist($entrepriseDeleteDef);
        $manager->flush();
    }
}
?>
