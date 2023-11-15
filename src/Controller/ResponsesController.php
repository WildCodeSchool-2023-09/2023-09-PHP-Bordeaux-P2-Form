<?php

namespace App\Controller;

use App\Model\ResponsesManager;
use App\Controller\AbstractController;

class ResponsesController extends AbstractController
{
    public function responses()
    {
         $userId = 2;
        $responsesManager = new ResponsesManager();
        $responses = $responsesManager->getResponses($userId);

        return $this->twig->render('Form/responses.html.twig', ['responses' => $responses]);
    }
}
