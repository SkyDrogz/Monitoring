<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
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
        // Role User
        $role = new Role();        
        $role->setNomRole('ROLE_ADMIN');
        $manager->persist($role);     
        $manager->flush();
        // Role Admin
        $role1 = new Role();       
        $role1->setNomRole('ROLE_SUPER_ADMIN');
        $manager->persist($role1);
        $manager->flush();  
        // User Admin
        $user = new User();
        $user->setIdentifiant('Baptiste');
        $user->setPassword('admin');
        $user->setRole( $role1);
        $plainPassword = $user->getPassword();
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setEmail("Baptiste@lieu.com");
        $user->setTel('034232329504');
        $user->setActif(1);
        $manager->persist($user);
        // User User
        $user1 = new User();
        $user1->setIdentifiant('Timothee');
        $user1->setPassword('admin');
        $user1->setRole($role);
        $plainPassword = $user1->getPassword();
        $encoded = $this->encoder->encodePassword($user1, $plainPassword);
        $user1->setPassword($encoded);
        $user1->setEmail("TImothee@lieu.com");
        $user1->setTel('0612992129');
        $user1->setActif(1);
        $manager->persist($user1);
        // User Edit
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
        //User Delete (passage inactif)
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
        // User Reactivation (passage Actif)
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
        // User Supression definitive
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
        
    }
}
?>