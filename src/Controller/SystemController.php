<?php

namespace App\Controller;

use App\Entity\Systeme;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SystemType;

class SystemController extends Controller
{
    /**
     * @Route("/system", name="system")
     */
    public function index()
    {
        // exit;
        // replace this line with your own code!
        return $this->render('system/index.html.twig');
    }

    /**
     * @Route("/system/new", name="system_new")
     */
    public function new(Request $request)
    {
      // Création du formulaire d'ajout d'un système
        $systeme = new Systeme();
        $form = $this->createForm(SystemType::class, $systeme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $systeme = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($systeme);
            $em->flush();
            return $this->redirectToRoute('system_new');
          }

        return $this->render('system/new.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/system/edit/{id}", name="system_edit")
     */
    public function edit(Request $request, $id)
    {
      // Création du formulaire d'édition d'un système
      $em = $this->getDoctrine()->getManager();
      $systeme = $em->getRepository(Systeme::class)->find($id);

      if ($systeme) {
        $form = $this->createForm(SystemType::class, $systeme);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                 $systeme = $form -> getData();
                 $em = $this->getDoctrine()->getManager();
                 $em -> persist($systeme);
                 $em->flush();
                 return $this->redirectToRoute('system');
        }
        return $this->render('system/edit.html.twig', array('form' =>$form->createView()));
      }
      else {
        return $this->redirectToRoute('system');
      }


    }

    /**
     * @Route("/system/consultation", name="system_consultation")
     */
    public function consultation()
    {
        $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
        return $this->render('system/consultation.html.twig', array(
            'systemListe' => $systemListe
        ));

    return new Response($system);
    }





}
