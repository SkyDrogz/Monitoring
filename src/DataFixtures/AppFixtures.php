<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\CategSysteme;
use App\Entity\Systeme;
use App\Entity\Entreprise;
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
      //------------------------------ Role ---------------------------------//
        // Role User
        $role = new Role();
        $role->setNomRole('ROLE_ADMIN');
        $manager->persist($role);

        // Role Admin
        $role1 = new Role();
        $role1->setNomRole('ROLE_SUPER_ADMIN');
        $manager->persist($role1);
        $manager->flush();

        //-------------------------- Utilisateurs ----------------------------//

        // Ajout de l'utilisateur en rôle Admin
        $user = new User();
        $user->setIdentifiant('Baptiste');
        $user->setPassword('admin');
        $user->setRole($role);
        $plainPassword = $user->getPassword();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setEmail("baptiste@lieu.com");
        $user->setTel('034232329504');
        $user->setActif(1);
        $manager->persist($user);

        // Ajout de l'utilisateur en rôle Utilisateur
        $user1 = new User();
        $user1->setIdentifiant('Timothee');
        $user1->setPassword('admin');
        $user1->setRole($role1);
        $plainPassword = $user1->getPassword();
        $encoded = $this->encoder->encodePassword($user1, $plainPassword);
        $user1->setPassword($encoded);
        $user1->setEmail("TImothee@lieu.com");
        $user1->setTel('0612992129');
        $user1->setActif(1);
        $manager->persist($user1);

        // Modification d'un utilisateur
        $user2 = new User();
        $user2->setIdentifiant('Richelieu');
        $user2->setPassword('test');
        $plainPassword = $user2->getPassword();
        $encoded = $this->encoder->encodePassword($user2, $plainPassword);
        $user2->setPassword($encoded);
        $user2->setEmail("Riche@lieu.com");
        $user2->setTel('0349504');
        $user2->setActif(1);
        $manager->persist($user2);

        // Suppression logique d'un utilisateur
        $user3 = new User();
        $user3->setIdentifiant('Rachid');
        $user3->setPassword('test');
        $plainPassword = $user3->getPassword();
        $encoded = $this->encoder->encodePassword($user3, $plainPassword);
        $user3->setPassword($encoded);
        $user3->setEmail("Rachide@lieu.com");
        $user3->setTel('0349504');
        $user3->setActif(1);
        $manager->persist($user3);

        // Réactivation d'un utilisateur
        $user4 = new User();
        $user4->setIdentifiant('Roger');
        $user4->setPassword('test');
        $plainPassword = $user4->getPassword();
        $encoded = $this->encoder->encodePassword($user4, $plainPassword);
        $user4->setPassword($encoded);
        $user4->setEmail("Roger@lieu.com");
        $user4->setTel('0349504');
        $user4->setActif(0);
        $manager->persist($user4);

        // Suppression définitive d'un utilisateur
        $user5 = new User();
        $user5->setIdentifiant('Remi');
        $user5->setPassword('test');
        $plainPassword = $user5->getPassword();
        $encoded = $this->encoder->encodePassword($user5, $plainPassword);
        $user5->setPassword($encoded);
        $user5->setEmail("Remi@lieu.com");
        $user5->setTel('0349504');
        $user5->setActif(1);
        $manager->persist($user5);

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

        // Ajout Systeme
        $systemAdd = new Systeme();
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

        // Ajout entreprise
        $entrepriseAdd = new Entreprise();
        $entrepriseAdd->setLibelle("EDF");
        $entrepriseAdd->setActif(1);
        $manager->persist($entrepriseAdd);
        $manager->flush();

        // Modification entreprise
        $entrepriseEdit = new Entreprise();
        $entrepriseEdit->setLibelle("Facebook");
        $entrepriseAdd->setActif(1);
        $manager->persist($entrepriseEdit);
        $manager->flush();

        // Suppression logique entreprise
        $entrepriseDelete = new Entreprise();
        $entrepriseDelete->setLibelle("Google");
        $entrepriseDelete->setActif(1);
        $manager->persist($entrepriseDelete);
        $manager->flush();

        // Réactivation entreprise
        $entrepriseReactivation = new Entreprise();
        $entrepriseReactivation->setLibelle("Priceminister");
        $entrepriseAdd->setActif(0);
        $manager->persist($entrepriseReactivation);
        $manager->flush();

        // Suppression définitive entreprise
        $entrepriseDeleteDef = new Entreprise();
        $entrepriseDeleteDef->setLibelle("Norauto");
        $entrepriseAdd->setActif(0);
        $manager->persist($entrepriseDeleteDef);
        $manager->flush();
    }
}
?>
