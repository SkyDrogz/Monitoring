<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntrepriseController extends Controller
{

    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index()
    {
        // Retourne la page d'index des entreprises
        return $this->render('entreprise/index.html.twig');
    }

    /**
     * @Route("/entreprise/new", name="entreprise_new")
     */
    public function newAction(Request $request)
    {
      // Création d'un objet de la classe entreprise
        $entreprise = new entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        //Si le formulaire est soumis et valide..
        if ($form->isSubmitted() && $form->isValid()) {
          //Ajout de l'entreprise dans la BDD
            $entreprise = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            // Affichage d'un FlashBag pour confirmer l'enregistrement de l'entreprise
            $request->getSession()->getFlashBag()->add('info', 'Entreprise bien enreigstré.');
            // Redirection à la page de création de l'entreprise
            return $this->redirectToRoute('entreprise_new');
        }
        // La page de création d'entreprise est retournée
        return $this->render('entreprise/new.html.twig', array('form' => $form->createView()));
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
        //Si le formulaire est soumis et valide..
        if ($form->isSubmitted() && $form->isValid()) {
          // Ajout des valeurs  modifiées dans la base de données
            $entreprise = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            //Redirection à la page des consultations des entreprises
            return $this->redirectToRoute('entreprise_read');
        }
        return $this->render('entreprise/edit.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/entreprise/read", name="entreprise_read")
     */
    public function readAction(Request $request)
    {
        //Flashbag pour tester si la consultation Entreprise s'affiche correctement
        $request->getSession()->getFlashBag()->add('testRead', "testRead");
        // Affiche toutes les entreprises trouvés dans la base de données dans la page de consultation
        $entrepriseListe = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();
        return $this->render('entreprise/read.html.twig', array(
            'entrepriseListe' => $entrepriseListe,
        ));

        return new Response($entreprise);
    }
    /**
     * @Route("/entreprise/delete/{id}", name="entreprise_delete")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
        // Met à jour l'entreprise en non active
        $em = $this->getDoctrine()->getManager();
        $entreprise->setActif(false);
        $em->persist($entreprise);
        $em->flush();
        // Retour à la page de consultation
        return $this->redirectToRoute('entreprise_read');
    }
    /**
     * @Route("/entreprise/active", name="entreprise_active")
     */
    public function active(Request $request)
    {
        //Affiche toutes les entreprises non active
        $entrepriseListe = $this->getDoctrine()->getRepository(entreprise::class)->findAll();
        return $this->render('entreprise/reactivation.html.twig', array(
            'entrepriseListe' => $entrepriseListe,
        ));

        return new Response($entreprise);
    }
    /**
     * @Route("/entreprise/reactive/{id}", name="entreprise_reactive")
     */
    public function activeAction(Request $request, entreprise $entreprise)
    {
      // Met en "ACTIF" l'entreprise séléctionnée
        $em = $this->getDoctrine()->getManager();
        $entreprise->setActif(true);
        $em->persist($entreprise);
        $em->flush();
        // Affichage d'un message Flashbag confirmant l'ajout
        $request->getSession()->getFlashBag()->add('info', "L'entreprise est réactivée.");
        //Redirection à la page de consultations des entreprises non-actives
        return $this->redirectToRoute('entreprise_active');
    }
    /**
     * @Route("/entreprise/deleteDef/{id}", name="entreprise_deleteDef")
     */
    public function deleteDefAction(Request $request, Entreprise $entreprise)
    {
      // Permet de supprimer définitivement l'entreprise
        $em = $this->getDoctrine()->getManager();
        $em->remove($entreprise);
        $em->flush();

        // Retour à la page de consultation des entreprises
        return $this->redirectToRoute('entreprise_read');
    }
}
