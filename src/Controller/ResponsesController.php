<?php

namespace App\Controller;

use App\Model\ResponsesManager;
use App\Controller\AbstractController;

class ResponsesController extends AbstractController
{
  //  public function responses()
  //  {
   //     $responseSessionId = 3;
  //      $responsesManager = new ResponsesManager();
   //     $response = $responsesManager->getResponses($responseSessionId);

       //    return $this->twig->render('Form/responses.html.twig', ['response' => $response]);
 //   }

    public function responses()
    {
        $userId = 3;
        $responsesManager = new ResponsesManager();
        $response = $responsesManager->getResponses($userId);

           return $this->twig->render('Form/responses.html.twig', ['response' => $response]);
    }
}
