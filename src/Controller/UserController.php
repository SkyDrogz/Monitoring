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

        if($form->isSubmitted() && $form->isValid()){
            $user = $form -> getData();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($user);
            $em->flush();
            return $this->redirectToRoute('user_new');
        }
        return $this->render('user/new.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/user/edit", name="user_edit")
     */
    public function editAction()
    {
        exit;
    }
    /**
     * @Route("/user/consultation", name="user_consultation")
     */
    public function consultationAction()
    {
        exit;
    }
    /**
     * @Route("/user/suppression", name="user_suppression")
     */
    public function suppressionAction()
    {
        exit;
    }
}
