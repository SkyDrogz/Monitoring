<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
    public function new()
    {
        // exit;
        // replace this line with your own code!
        return $this->render('user/new.html.twig');
    }
}
