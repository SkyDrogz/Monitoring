<?php
namespace App\DataFixtures;

use App\Entity\User;
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
    }
}
?>