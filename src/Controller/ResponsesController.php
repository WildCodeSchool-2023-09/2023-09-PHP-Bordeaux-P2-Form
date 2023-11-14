<?php

namespace App\Controller;

use App\Model\ResponsesManager;
use App\Controller\AbstractController;

class ResponsesController extends AbstractController
{
    public function responses()
    {
        $responseSessionId = 1;
        $responsesManager = new ResponsesManager();
        $response = $responsesManager->getResponses($responseSessionId);

           return $this->twig->render('Form/responses.html.twig', ['response' => $response]);
    }
}
