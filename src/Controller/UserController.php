<?php

namespace App\Controller;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
  /**
  * @Route("/", name="index")
  */
  public function indexAccueil()
{
    $user = $this->getUser();
    if($user->getRole()->getNomRole() == "ROLE_SUPER_ADMIN")
    {
      $role = "administrateur";
    }
    else {
      $role = "utilisateur";
    }

    $date = date_create(date("Y-m-d H:i:s"));
    $date = new \Datetime();
    $em = $this->getDoctrine()->getManager();
    $user->setDateConnexion($date);
    $em->persist($user);
    $em->flush();


    $message = "Bonjour " . $user->getIdentifiant() . ", vous êtes connecté(e) en tant que ".$role." pour l'entreprise ".$user->getEntreprise()->getLibelle().".";
    $messageBis = "Cliquez ici pour visualiser la liste des systèmes.";
    // exit;
    // replace this line with your own code!
    return $this->render('base.html.twig', array(
  'message' => $message,
  'messageBis' => $messageBis));

  return new Response($roleuser);
  }
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        // exit;
        // replace this line with your own code!
        return $this->render('user/index.html.twig');
    }
    /**
     * @Route("/user/new", name="user_new")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //Submit
        if($form->isSubmitted() && $form->isValid()){
            $user = $form -> getData();
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
              $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été enregistré.");
              return $this->redirectToRoute('user_new');
            }
            else {
              $request->getSession()->getFlashBag()->add('info', "Le pseudo est déjà utilisé. Choisissez-en un autre !");
              return $this->redirectToRoute('user_new');
            }
        }
        return $this->render('user/new.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
      $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
      // Création du formulaire d'édition d'un système
      $em = $this->getDoctrine()->getManager();
      //$user = $em->getRepository(User::class)->find($id);
      $form = $this->createForm(UserType::class, $user);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
               $user = $form -> getData();
               $check = false;
               $plainPassword = $user->getPassword();
               $encoded = $encoder->encodePassword($user, $plainPassword);
               $user->setPassword($encoded);
               $em = $this->getDoctrine()->getManager();
               $em -> persist($user);
               $em->flush();
               $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été modifié.");
               return $this->redirectToRoute('user_consultation');
      }
      return $this->render('user/edit.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/user/consultation", name="user_consultation")
     */
    public function consultationAction()
    {
        $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/consultation.html.twig', array(
            'userListe' => $userListe
        ));

    return new Response($user);
    }
    /**
     * @Route("/user/suppression/{id}", name="user_suppression")
     */
    public function suppressionAction(Request $request,User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setActif(false);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_consultation');

    }
       /**
     * @Route("/user/active", name="user_active")
     */
    public function active()
    {
      $userListe = $this->getDoctrine()->getRepository(user::class)->findAll();
        return $this->render('user/reactivation.html.twig', array(
            'userListe' => $userListe
        ));

    return new Response($user);
    }
    /**
     * @Route("/user/reactive/{id}", name="user_reactive")
     */
    public function activeAction(Request $request,user $user)
    {
      $em = $this->getDoctrine()->getManager();
      $user->setActif(true);
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_active');
    }
    /**
     * @Route("/user/consultationTest", name="user_consultationTest")
     */
    public function consultationTest()
    {
      return $this->render('user/consultationTest.html.twig');
    }
}
