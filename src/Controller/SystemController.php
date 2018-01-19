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
  * @Route("/", name="index")
  */
  public function indexAccueil()
  {
    // exit;
    // replace this line with your own code!
    return $this->render('base.html.twig');
  }
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
      $request->getSession()->getFlashBag()->add('info', "Le système à bien été rajouté.");
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
      // $command=null;
      $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
      foreach($systemListe as $system){
        if($system->getActif()== 1){
        if($system->getCategSysteme()->getCategorie() == "Serveur"){
<<<<<<< HEAD
      $command = exec('ping '.$system->getUrl()." -n 1");
      if (preg_match("#Minimum#",$command))
      {
        $system->setEtat('Online');
      }
      else {
      $system->setEtat('Offline');
    }
    }
      if($system->getCategSysteme()->getCategorie() == "API"){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_PORT => "9200",
          CURLOPT_URL => $system->getUrl(),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $system->getRequete(),
          CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: a9414de1-6e95-fbc7-9c3c-94983fa42efb"
          ),
        ));
        if(curl_exec($curl) === false)
        {
          curl_close($curl);
          $system->setEtat("Offline (Serveur)");
=======
        $command = exec('ping '.$system->getUrl()." -n 1");
        if (preg_match("#Minimum#",$command))
        {
          $system->setEtat('Online');
>>>>>>> 72d325d5cab13d35368787a9b5f7f20f01f4c368
        }
        else
        {
          $system->setEtat('Offline');
        }
      }elseif($system->getCategSysteme()->getCategorie() == "Site internet"){
         // Création d'une nouvelle ressource cURL
         $curl = curl_init();

         curl_setopt_array($curl, array(
           CURLOPT_URL => $system->getUrl(),
           CURLOPT_RETURNTRANSFER => true,
         ));
        // Récupération de l'URL et affichage sur le navigateur
        $str =curl_exec($curl);
       
          if ($str === false)
        {
          $system->setEtat('Offline');
        }
        else
        {
          $system->setEtat('Online');
        }

        // Fermeture de la session cURL
        curl_close($curl);
      }elseif($system->getCategSysteme()->getCategorie() == "API"){
          $curl = curl_init();
  
          curl_setopt_array($curl, array(
            CURLOPT_PORT => "9200",
            CURLOPT_URL => $system->getUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $system->getRequete(),
            CURLOPT_HTTPHEADER => array(
              "Cache-Control: no-cache",
              "Content-Type: application/json",
              "Postman-Token: a9414de1-6e95-fbc7-9c3c-94983fa42efb"
            ),
          ));
          if(curl_exec($curl) === false)
          {
<<<<<<< HEAD
            //Test requete JSON
            if (preg_match("#error#",$response)) {
              $system->setEtat('Offline (Requête JSON incorrecte)');
            } else {
              $system->setEtat('Online');
            }
          }
          else {
            $system->setEtat('Offline (Résultat attendu introuvable)');
=======
            curl_close($curl);
            $system->setEtat("Offline (Serveur)");
            
          }
          else
          {
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            //Test résultat attendu
            if(preg_match("#".$system->getResultatAttendu()."#",$response))
            {
              //Test requete JSON
              if (preg_match("#error#",$response)) {
                $system->setEtat('Offline (Requête JSON incorrecte)');
              } else {
                $system->setEtat('Online');
              }
            }
            else {
  
              $system->setEtat('Offline (Résultat attendu introuvable)');
            }
            
>>>>>>> 72d325d5cab13d35368787a9b5f7f20f01f4c368
          }
          
        }
        
      }
<<<<<<< HEAD
      return $this->render('system/consultation.html.twig', array(
        'systemListe' => $systemListe
      ));
      return new Response($system);
=======
      
>>>>>>> 72d325d5cab13d35368787a9b5f7f20f01f4c368
    }

      return $this->render('system/consultation.html.twig', array(
        'systemListe' => $systemListe
      ));
      return new Response($system);
  }
    
    
  
  /**
  * @Route("/system/suppression/{id}", name="system_suppression")
  */
  public function suppressionAction(Request $request,Systeme $systeme)
  {
    $em = $this->getDoctrine()->getManager();
    $systeme->setActif(false);
    $em->persist($systeme);
    $em->flush();

    return $this->redirectToRoute('system_consultation');

  }
  /**
  * @Route("/system/active", name="system_active")
  */
  public function active()
  {
    $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
    return $this->render('system/reactivation.html.twig', array(
      'systemListe' => $systemListe
    ));

    return new Response($system);
  }
  /**
  * @Route("/system/reactive/{id}", name="system_reactive")
  */
  public function activeAction(Request $request,Systeme $systeme)
  {
    $em = $this->getDoctrine()->getManager();
    $systeme->setActif(true);
    $em->persist($systeme);
    $em->flush();

    return $this->redirectToRoute('system_active');
  }






}
