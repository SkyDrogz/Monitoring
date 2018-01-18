<?php

namespace App\Controller;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;

class UserController extends Controller
{

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
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //Submit
        if($form->isSubmitted() && $form->isValid()){
            $user = $form -> getData();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enreigstré.');
            return $this->redirectToRoute('user_new');
        }
        return $this->render('user/new.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function edit(Request $request, User $user)
    {
      // Création du formulaire d'édition d'un système
      $em = $this->getDoctrine()->getManager();
      //$user = $em->getRepository(User::class)->find($id);
      $form = $this->createForm(UserType::class, $user);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
               $user = $form -> getData();
               $em = $this->getDoctrine()->getManager();
               $em -> persist($user);
               $em->flush();
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
}
