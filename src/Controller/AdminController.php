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

    // dump($passwordEncoder->isPasswordValid($user, $request->get("_password"))); exit;
    //
    // if($request->get("_password") !== null && $request->get("_username") !== null && $passwordEncoder->isPasswordValid($user, $request->get("_password")))
    // {
    //
    // }

    $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
    foreach($userListe as $user)
    {
      if($user->getUsername()==$lastUsername)
      {
        $date = date_create(date("Y-m-d H:i:s"));
        $date = new \Datetime();
        $em = $this->getDoctrine()->getManager();
        $user->setDateConnexion($date);
        $em->persist($user);
        $em->flush();
      }

    }

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

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();
    $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
    foreach($userListe as $user)
    {
      if($user->getUsername()==$lastUsername)
      {
        $date = date_create(date("Y-m-d H:i:s"));
        $date = new \Datetime();
        $em = $this->getDoctrine()->getManager();
        $user->setDateDeconnexion($date);
        $em->persist($user);
        $em->flush();
      }
    }
     session_destroy();
    return $this->redirectToRoute('login');
  }


}
