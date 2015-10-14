<?php

namespace Kaliop\ClassSelectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KaliopFieldTypeClassSelectBundle:Default:index.html.twig', array('name' => $name));
    }
}
