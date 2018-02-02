<?php

namespace App\Controller;
use App\Entity\Entreprise;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntrepriseType;

class EntrepriseController extends Controller
{

    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index()
    {
        // exit;
        // replace this line with your own code!
        return $this->render('entreprise/index.html.twig');
    }

    /**
     * @Route("/entreprise/new", name="entreprise_new")
     */
    public function newAction(Request $request)
    {
        $entreprise = new entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        //Submit
        if($form->isSubmitted() && $form->isValid()){
            $entreprise = $form -> getData();
            $em = $this->getDoctrine()->getManager();
            $em -> persist($entreprise);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Entreprise bien enreigstré.');
            return $this->redirectToRoute('entreprise_new');
        }
        return $this->render('entreprise/new.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/entreprise/edit/{id}", name="entreprise_edit")
     */
    public function edit(Request $request, entreprise $entreprise)
    {
      // Création du formulaire d'édition d'un système
      $em = $this->getDoctrine()->getManager();
      //$entreprise = $em->getRepository(entreprise::class)->find($id);
      $form = $this->createForm(EntrepriseType::class, $entreprise);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
               $entreprise = $form -> getData();
               $em = $this->getDoctrine()->getManager();
               $em -> persist($entreprise);
               $em->flush();
               return $this->redirectToRoute('entreprise_read');
      }
      return $this->render('entreprise/edit.html.twig', array('form' =>$form->createView()));
    }
    /**
     * @Route("/entreprise/read", name="entreprise_read")
     */
    public function readAction()
    {
        $entrepriseListe = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();
        return $this->render('entreprise/read.html.twig', array(
            'entrepriseListe' => $entrepriseListe
        ));

    return new Response($entreprise);
    }
    /**
     * @Route("/entreprise/delete/{id}", name="entreprise_delete")
     */
    public function deleteAction(Request $request,Entreprise $entreprise)
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise->setActif(false);
        $em->persist($entreprise);
        $em->flush();

        return $this->redirectToRoute('entreprise_read');
    }
      /**
     * @Route("/entreprise/active", name="entreprise_active")
     */
    public function active(Request $request)
    {
      $entrepriseListe = $this->getDoctrine()->getRepository(entreprise::class)->findAll();
        return $this->render('entreprise/reactivation.html.twig', array(
            'entrepriseListe' => $entrepriseListe
        ));

    return new Response($entreprise);
    }
    /**
     * @Route("/entreprise/reactive/{id}", name="entreprise_reactive")
     */
    public function activeAction(Request $request,entreprise $entreprise)
    {
      $em = $this->getDoctrine()->getManager();
      $entreprise->setActif(true);
      $em->persist($entreprise);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "L'entreprise est réactivée.");
      return $this->redirectToRoute('entreprise_active');
    }
     /**
     * @Route("/entreprise/deleteDef/{id}", name="entreprise_deleteDef")
     */
    public function deleteDefAction(Request $request,Entreprise $entreprise)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entreprise);
        $em->flush();

        return $this->redirectToRoute('entreprise_read');
    }
}
