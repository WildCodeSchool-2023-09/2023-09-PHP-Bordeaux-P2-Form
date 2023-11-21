<?php

namespace App\Controller;

use App\Model\FormManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $formManager = new FormManager();
        $forms = $formManager->getAllFinished();
        return $this->twig->render('Home/index.html.twig', ['forms' => $forms]);
    }

    /*
    TODO : add an errors page who take $_SESSION['errors'] and use it.
    */
}
