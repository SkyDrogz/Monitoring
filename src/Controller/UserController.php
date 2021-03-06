<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAccueil(Request $request)
    {
      // Récupération de l'utilisateur
        $user = $this->getUser();
        // Si l'utilisateur n'est pas null ..
        if ($user != null) {
           // Vérification du rôle de l'utilisateur
            if ($user->getRole()->getNomRole() == "ROLE_SUPER_ADMIN") {
                $role = "administrateur";
            } else {
                $role = "utilisateur";
            }
            $request->getSession()->getFlashBag()->add('info', $role);
            // Initialisation et ajout de la date de connexion de l'utilisateur
            $date = date_create(date("Y-m-d H:i:s"));
            $date = new \Datetime();
            $em = $this->getDoctrine()->getManager();
            $user->setDateConnexion($date);
            $em->persist($user);
            $em->flush();

            // Message visible dans la page d'accueil montrant son identifiant, rôle et son entreprise
            $message = "Bonjour " . $user->getIdentifiant() . ", vous êtes connecté(e) en tant que " . $role . " pour l'entreprise " . $user->getEntreprise()->getLibelle() . ".";
            $messageBis = "Cliquez ici pour visualiser la liste des systèmes.";
            // Retourne la base avec les deux messages précédents
            return $this->render('base.html.twig', array(
                'message' => $message,
                'messageBis' => $messageBis));
            return new Response($roleuser);

        } else {
          // Si l'utilisateur est null, redirection à la page de connexion
            return $this->redirectToRoute('login');
        }
    }
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
      // Retourne la page d'index des utilisateurs
        return $this->render('user/index.html.twig');
    }
    /**
     * @Route("/user/new", name="user_new")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
      // Création d'un objet de la classe User
        $user = new User();
        //$userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //Si le formulaire est soumis et valide..
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Check pour savoir si l'utilisateur est déjà enregistré sous le même nom
            $userTest = $this->getDoctrine()->getRepository(User::class)->findOneByIdentifiant($user->getIdentifiant());
            // Initialisation de la variable Check
            $check = false;

            //Si l'utilisateur à un pseudo déjà utilisé ...
            if ($userTest !== null) {
              // Affichage d'un message avec l'erreur et retour à la page ajout d'un utilisateur
                $check = true;
                $request->getSession()->getFlashBag()->add('info', "Le pseudo est déjà utilisé. Choisissez-en un autre !");
                return $this->redirectToRoute('user_new');
            }
            // Encodage du mot de passe
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            // Si l'utilisateur à un identifiant non utilisé dans la BDD...
            if ($check == false) {
              // Ajout de l'utilisateur
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                // Affichage d'un message de confirmation d'ajout
                $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été enregistré.");
                // Retour à la page d'ajout
                return $this->redirectToRoute('user_new');
            }
        }
        return $this->render('user/new.html.twig', array('form' => $form->createView()));
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

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
          // Edition de l'utilisateur avec encodage du mot de passe
            $user = $form->getData();
            $check = false;
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // Affichage d'un message de confirmation de modification
            $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été modifié.");
            return $this->redirectToRoute('user_read');
        }
        return $this->render('user/edit.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/user/read", name="user_read")
     */
    public function readAction(Request $request)
    {
        //Flashbag pour tester si la consultation Entreprise s'affiche correctement
        $request->getSession()->getFlashBag()->add('testRead', "testRead");
        $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/read.html.twig', array(
            'userListe' => $userListe,
        ));

        return new Response($user);
    }
    /**
     * @Route("/user/delete/{id}", name="user_delete")
     */
    public function deleteAction(Request $request, User $user)
    {
      // Suppression logique ( utilisateur en non actif )
        $em = $this->getDoctrine()->getManager();
        $user->setActif(false);
        $em->persist($user);
        $em->flush();

        //Retourne la page de consultation des utilisateurs
        return $this->redirectToRoute('user_read');

    }
    /**
     * @Route("/user/active", name="user_active")
     */
    public function active()
    {
      // Récuperation des utilisateurs
        $userListe = $this->getDoctrine()->getRepository(user::class)->findAll();
        return $this->render('user/reactivation.html.twig', array(
            'userListe' => $userListe,
        ));

        return new Response($user);
    }
    /**
     * @Route("/user/reactive/{id}", name="user_reactive")
     */
    public function activeAction(Request $request, User $user)
    {
      // Récativation d'un utilisateur
        $em = $this->getDoctrine()->getManager();
        $user->setActif(true);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_active');
    }
    /**
     * @Route("/user/actApprouve/{id}", name="user_actApprouve")
     */
    public function activationApprouveAction(Request $request, user $user)
    {
      // Approbation d'un utilisateur en initialisant sa date de connexion et de déconnexion
        $today = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $user->setActif(true);
        $user->setDateDeconnexion($today);
        $user->setDateConnexion($today);

        $role = $em->getRepository(Role::class)->findById(1);

        // Mise à jour automatique de l'utilisateur en role d'Utilisateur
        $user->setRole($role[0]);
        $em->persist($user);
        $em->flush();

        // Retour à la page de consultation d'utilisateur
        return $this->redirectToRoute('user_read');
    }
    /**
     * @Route("/user/deleteDef/{id}", name="user_deleteDef")
     */
    public function deleteDefAction(Request $request, User $user)
    {
        // Suppression définitive
        $em = $this->getDoctrine()->getManager();
        $user->setActif(false);
        $em->remove($user);
        $em->flush();

        // Retour à la page de consultation des utilisateurs
        return $this->redirectToRoute('user_read');

    }
}
