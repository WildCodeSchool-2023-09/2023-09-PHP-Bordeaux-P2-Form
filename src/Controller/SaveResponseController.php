<?php

namespace App\Controller;

use App\Model\CompletedFormManager;
use App\Model\ResponseSessionManager;
use App\Model\ResponsesManager;
use App\Model\SaveResponseManager;

class SaveResponseController extends AbstractController
{
    public function saveForm(int $formId)
    {
        $completedFormManager = new CompletedFormManager();
        $respSessionManager = new ResponseSessionManager(); // cette variable s'appelait $responseSessionManager
        // mais phpmd la trouvait trop longue
        $responseManager = new ResponsesManager();



        if (isset($_SESSION['user_id'])) {
            $user = $_SESSION['user_id'];
        } else {
            $user = $respSessionManager->createUnknownUser();
        }
        $responders = $responseManager->getResponders($formId);

        $responders = array_map(fn ($arr) => $arr['user_id'], $responders);

        if (in_array($user, $responders)) {
            header('location: /alreadyAnswered');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sentForm = array_map('trim', $_POST);
            $errors = [];

            foreach ($sentForm as $key => $formResponse) {
                $errors = $this->verifyResponses($formResponse);

                return $this->twig->render('Form/errors.html.twig', ['errors' => $errors]);
            }


            foreach ($sentForm as $key => $formResponse) {
                $responseArray = explode('_', $key);
                $toolFormId = intval($responseArray[0]);


                if ($formResponse === 'on') {
                    unset($responseArray[0]);
                    $response = implode('_', $responseArray);
                } else {
                    $response = $formResponse;
                    $sessionId = $respSessionManager->insert($toolFormId, $user);
                    $completedFormManager->insert($sessionId, $response);
                }
            }
        }

        return $this->twig->render('Form/thanks.html.twig');
    }


    public function already(): string
    {

        return $this->twig->render('Form/already.html.twig');
    }


    public function verifyResponses($formResponse)
    {
        $errors = [];
        if (empty($formResponse)) {
            $errors[] = "Le formulaire ne doit pas être vide.";
        } elseif (strlen($formResponse) > 100) {
                     $errors[] = 'Votre réponse doit comporter au maximum 100 caractères.';
        } elseif (!preg_match('/^[a-zA-Z0-9]*$/', $formResponse)) {
                $errors[] = "texte invalide";
        }


        return $errors;
    }
}
