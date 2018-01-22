<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class SecurityController extends Controller
{
  /**
   * @Route("/admin/login", name="login")
   */
  public function login()
  {
    $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/login.html.twig', array(
            'userListe' => $userListe
        ));
  }
}
