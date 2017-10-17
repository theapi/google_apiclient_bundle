<?php

namespace Theapi\GoogleApiClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TheapiGoogleApiClientBundle:Default:index.html.twig');
    }
}
