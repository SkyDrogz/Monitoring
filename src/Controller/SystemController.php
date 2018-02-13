<?php

namespace App\Controller;

use App\Entity\Systeme;
use App\Form\SystemType;
use App\Entity\InfoProtect;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemController extends Controller
{
    /**
     * @Route("/system", name="system")
     */
    public function index()
    {
        // Retourne l'index des systèmes
        return $this->render('system/index.html.twig');
    }

    /**
     * @Route("/system/new", name="system_new")
     */
    function new (Request $request) {
        // Création du formulaire d'ajout d'un système
        $systeme = new Systeme();
        $form = $this->createForm(SystemType::class, $systeme);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide...
        if ($form->isSubmitted() && $form->isValid()) {
          //Met les valeurs dans la BDD
            $systeme = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($systeme);
            $em->flush();
            // Affichage d'un message FlashBag confirmant l'ajout du système
            $request->getSession()->getFlashBag()->add('msg', "Le système à bien été rajouté.");
            // Retourne la page d'ajout d'un système
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

        //Si le système existe, récupération du formulaire SystemType
        if ($systeme) {
            $form = $this->createForm(SystemType::class, $systeme);
            $form->handleRequest($request);

            //Si le formulaire est soumis et validé..
            if ($form->isSubmitted() && $form->isValid()) {
              // Données modifié enregistré dans la BDD
                $systeme = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($systeme);
                $em->flush();
                // Redirection à la route System
                return $this->redirectToRoute('system');
            }
            return $this->render('system/edit.html.twig', array('form' => $form->createView()));
        } else {
          // Si le système n'est pas trouvé, redirection à la page consultation
            return $this->redirectToRoute('system_read');
        }

    }
    /**
     * @Route("/system/read", name="system_read")
     */
    public function read(Request $request)
    {
        //Flashbag pour tester si la consultation Entreprise s'affiche correctement
        $request->getSession()->getFlashBag()->add('testRead', "testRead");
        // Met dans une liste tout les systèmes de la BDD
        $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
        // Retourne la page de consultation
        return $this->render('system/read.html.twig', array(
            'systemListe' => $systemListe,
        ));
        return new Response($system);
    }

    /**
     * @Route("/system/delete/{id}", name="system_delete")
     */
    public function deleteAction(Request $request, Systeme $systeme)
    {
      // Met le système en non-actif
        $em = $this->getDoctrine()->getManager();
        $systeme->setActif(false);
        $em->persist($systeme);
        $em->flush();

        //Retourne la page de consultation
        return $this->redirectToRoute('system_read');

    }
    /**
     * @Route("/system/active", name="system_active")
     */
    public function active()
    {
      // Recherche tout les systèmes
        $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
        return $this->render('system/reactivation.html.twig', array(
            'systemListe' => $systemListe,
        ));

        return new Response($system);
    }
    /**
     * @Route("/system/reactive/{id}", name="system_reactive")
     */
    public function activeAction(Request $request, Systeme $systeme)
    {
      // Met le système séléctionné en actif
        $em = $this->getDoctrine()->getManager();
        $systeme->setActif(true);
        $em->persist($systeme);
        $em->flush();

        //Redirection à la page des systèmes non activés
        return $this->redirectToRoute('system_active');
    }

/**
 * @Route("/system/deleteDef/{id}", name="system_deleteDef")
 */
    public function deleteDefAction(Request $request, Systeme $systeme)
    {
      // Supprime le système définitivement
        $em = $this->getDoctrine()->getManager();
        $em->remove($systeme);
        $em->flush();

        // Retour à la page de système non actif
        return $this->redirectToRoute('system_active');

    }
/**
 * @Route("/system/read/cron/linux/4530945389", name="system_read_cron")
 */
    public function readCron(Request $request)
    {
        $var ="Test";
        dump($var);
        $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
        foreach ($systemListe as $system) {
            if ($system->getActif() == 1) {
                if ($system->getCategSysteme()->getCategorie() == "Serveur") {
                    $command = exec('ping ' . $system->getUrl() . " -n 1");
                    if (preg_match("#Minimum#", $command)) {
                        $system->setEtat('Online');
                    } else {
                        $system->setEtat('Offline');
                    }
                } elseif ($system->getCategSysteme()->getCategorie() == "Site internet") {
        dump($var);

                    // Création d'une nouvelle ressource cURL
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $system->getUrl(),
                        CURLOPT_RETURNTRANSFER => true,
                    ));
                    // Récupération de l'URL et affichage sur le navigateur
                    $str = curl_exec($curl);

                    if ($str === false) {
                        $system->setEtat('Offline');
                    } else {
                        $system->setEtat('Online');
                    }

                    // Fermeture de la session cURL
                    curl_close($curl);
                } elseif ($system->getCategSysteme()->getCategorie() == "API") {
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
                            "Postman-Token: a9414de1-6e95-fbc7-9c3c-94983fa42efb",
                        ),
                    ));
                    if (curl_exec($curl) === false) {
                        curl_close($curl);
                        $system->setEtat("Offline (Serveur)");

                    } else {
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);
                        //Test résultat attendu
                        if (preg_match("#" . $system->getResultatAttendu() . "#", $response)) {
                            //Test requete JSON
                            if (preg_match("#error#", $response)) {
                                $system->setEtat('Offline (Requête JSON incorrecte)');
                            } else {
                                $system->setEtat('Online');
                            }
                        } else {

                            $system->setEtat('Offline (Résultat attendu introuvable)');
                        }
                    }

                }

            }
            dump($var);

            $today = new \Datetime();
            $diff = $system->getDateOffline()->diff($today);
            // vérification de l'état du systeme, du delai de répétition par rapport à la dernière DateOffline enregistrée et récupération du niveau d'urgence.
            if ($system->getEtat() !== "Online" && $diff->i >= $system->getRepetition() && $system->getNiveauUrgence() == 1) {

                $date = date_create(date("Y-m-d H:i:s"));
                $date = new \Datetime();
                $system->setDateOffline($date);
                $curl = curl_init();

                $infoProtect = new InfoProtect();
                $infoProtect = $this->getDoctrine()->getRepository(infoProtect::class)->findOneById(1);
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $infoProtect->getUrl().
                    urlencode($system->getCategSysteme()->getCategorie() . " '" . $system->getNom() . "' est offline depuis le "
                        . date_format($system->getDateOffline(), "Y-m-d H:i:s")) . "&num=" . $system->getUser()->getTel(),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 60,
                ));
                curl_exec($curl);
                // Creation du transport

                $infoProtect = new InfoProtect();
                $infoProtect = $this->getDoctrine()->getRepository(infoProtect::class)->findOneById(2);
                $transport = (new \Swift_SmtpTransport('ssl0.ovh.net', 465, 'ssl'))
                // Récupération des identifiant de connexion de l'email.
                ->setUsername($infoProtect->getEmail())
                    ->setPassword($infoProtect->getIdentifiant())
                ;

                $mailer = new \Swift_Mailer($transport);

                // Creation du message
                $message = (new \Swift_Message('Alerte Offline'))
                    ->setFrom([$infoProtect->getEmail() => 'Nexus Création'])
                    ->setTo([$system->getUser()->getEmail() => $system->getUser()->getIdentifiant()])
                    ->setBody($system->getCategSysteme()->getCategorie() . " '" . $system->getNom() . "' est offline depuis le " . date_format($system->getDateOffline(), "Y-m-d H:i:s"))
                ;

                // Envoie du message
                $result = $mailer->send($message);

            } elseif ($system->getEtat() !== "Online" && $diff->i >= $system->getRepetition()) {

                $infoProtect = new InfoProtect();
                $infoProtect = $this->getDoctrine()->getRepository(infoProtect::class)->findOneById(2);

                $date = date_create(date("Y-m-d H:i:s"));
                $date = new \Datetime();
                $system->setDateOffline($date);
                // Creation du transport
                $transport = (new \Swift_SmtpTransport('ssl0.ovh.net', 465, 'ssl'))
                     ->setUsername($infoProtect->getEmail())
                    ->setPassword($infoProtect->getIdentifiant())
                ;

                $mailer = new \Swift_Mailer($transport);

                // Creation du message
                $message = (new \Swift_Message('Alerte Offline'))
                    ->setFrom([$infoProtect->getEmail() => 'Nexus Création'])
                    ->setTo([$system->getUser()->getEmail() => $system->getUser()->getIdentifiant()])
                    ->setBody($system->getCategSysteme()->getCategorie() . " '" . $system->getNom() . "' est offline depuis le " . date_format($system->getDateOffline(), "Y-m-d H:i:s"))
                ;

                // Envoie du message
                $result = $mailer->send($message);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($system);
            $em->flush();
        }

        return new Response("");
    }

}
