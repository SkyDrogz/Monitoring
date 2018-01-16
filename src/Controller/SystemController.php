<?php

namespace App\Controller;

use App\Entity\Systeme;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
        $systeme->setNom('Nom du système');
        $systeme->setURL('URL du système');

        $form = $this->createFormBuilder($systeme)
            ->add('nom', TextType::class)
            ->add('url', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Créer un système'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $systeme = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($systeme);
            $em->flush();
            return $this->redirectToRoute('system_new');
          }

        return $this->render('system/new.html.twig', array(
            'form' => $form->createView(),
        ));
        // exit;
        // replace this line with your own code!
        return $this->render('system/new.html.twig');
    }

    /**
     * @Route("/system/edit", name="system_edit")
     */
    public function edit($id)
    {
      // Création du formulaire d'édition d'un système
      


        // exit;
        // replace this line with your own code!
        return $this->render('system/edit.html.twig');
    }
}
