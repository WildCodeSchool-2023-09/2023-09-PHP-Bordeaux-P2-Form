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

        $groupedResponses = $this->groupResponsesByQuestion();

        $collated = $this->collateResponses();



        return $this->twig->render('Form/responses.html.twig', ['responses' => $responses, 'formTitle' =>  $formTitle,
        'collated' => $collated, 'groupedResponses' => $groupedResponses]);
    }


    public function collateResponses()
    {
        $formId = 1;
        $result = [];

        $responsesManager = new ResponsesManager();
        $collatedResponses = $responsesManager->collatedResponses($formId);

        foreach ($collatedResponses as $response) {
            $result[] = [
            'question' => $response['label'],
            'response' => $response['value']
            ];
        }

        return $result;
    }

    public function groupResponsesByQuestion()
    {


        $collatedResponses = $this->collateResponses();


        $groupedResponses = [];

        foreach ($collatedResponses as $response) {
            $question = $response['question'];
            $groupedResponses[$question][] = $response['response'];
        }

        return $groupedResponses;
    }
}
