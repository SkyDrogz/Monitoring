<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Role;
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
    if ($user!= null)
    {
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
    }else{
      return $this->redirectToRoute('login');
    }
  }
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
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
               return $this->redirectToRoute('user_read');
      }
      return $this->render('user/edit.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/user/read", name="user_read")
     */
    public function readAction()
    {
        $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/read.html.twig', array(
            'userListe' => $userListe
        ));

    return new Response($user);
    }
    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function deleteAction(Request $request,User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setActif(false);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_read');

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
    public function activeAction(Request $request,User $user)
    {
      $em = $this->getDoctrine()->getManager();
      $user->setActif(true);
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_active');
    }
        /**
     * @Route("/user/approuve/", name="user_approuve")
     */
    public function approuveAction()
    {
      $userListe = $this->getDoctrine()->getRepository(user::class)->findAll();
      return $this->render('user/approuve.html.twig', array(
          'userListe' => $userListe
      ));

  return new Response($user);
    }
        /**
     * @Route("/user/actApprouve/{id}", name="user_actApprouve")
     */
    public function activationApprouveAction(Request $request,user $user)
    {
      $today = new \DateTime();
      $em = $this->getDoctrine()->getManager();
      $user->setActif(true);
      $user -> setDateDeconnexion($today);
      $user -> setDateConnexion($today);

      $role=$em->getRepository(Role::class)->findById(1);
     
      $user -> setRole($role[0]);
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_approuve');
    }
     /**
     * @Route("/user/deleteDef/{id}", name="user_deleteDef")
     */
    public function deleteDefAction(Request $request,User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setActif(false);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_approuve');

    }
}
