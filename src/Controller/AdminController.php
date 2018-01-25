<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends Controller
{
  /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
      // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();
    $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
    return $this->render('admin/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));

    }
  /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(AuthenticationUtils $authUtils,Request $request)
    {

      $user = $this->getUser();
      $date = date_create(date("Y-m-d H:i:s"));
      $date = new \Datetime();
      $em = $this->getDoctrine()->getManager();
      $user->setDateDeconnexion($date);
      $em->persist($user);
      $em->flush();
     session_destroy();
      return $this->redirectToRoute('login');
  }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        $user->setIdentifiant("_username");
        $user->setPassword("_password");
        $user->setEmail("_email");
        $user->setTel("_tel");
        $user->setActif(0);
        $check = false;
            foreach($userListe as $unUser)
            {
              if($user->getIdentifiant() == $unUser->getIdentifiant())
              {
                $check = true;
              }
            }
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            if($check == false)
            {
              $em = $this->getDoctrine()->getManager();
              $em -> persist($user);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La demande à bien été effectuée, une réponse  vous seras communiqué par mail dans les plus bref délais");
              return $this->redirectToRoute('login');
            }
            else {
              $request->getSession()->getFlashBag()->add('info', "Le pseudo est déjà utilisé. Choisissez-en un autre !");
              return $this->redirectToRoute('login');
            }
    }


}
