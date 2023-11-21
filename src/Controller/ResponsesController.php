<?php

namespace App\Controller;

use App\Model\ResponsesManager;
use App\Controller\AbstractController;

class ResponsesController extends AbstractController
{
    public function responses()
    {
        $formTitle = null;
        $username = 'username1';
        $responsesManager = new ResponsesManager();
        $responses = $responsesManager->getResponses($username);

        if (!empty($responses)) {
            $formTitle = $responses[0];
        }

        return $this->twig->render('Form/responses.html.twig', ['responses' => $responses, 'formTitle' =>  $formTitle]);
    }
}
