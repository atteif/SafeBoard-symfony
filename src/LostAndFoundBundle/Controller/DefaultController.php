<?php

namespace LostAndFoundBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/home" , name="atef")
     */
    public function indexAction()
    {
        return $this->render('LostAndFound/home.html.twig');
    }
}
