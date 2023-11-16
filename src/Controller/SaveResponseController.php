<?php

namespace App\Controller;

use App\Model\CompletedFormManager;
use App\Model\ResponseSessionManager;
use App\Model\SaveResponseManager;

class SaveResponseController extends AbstractController
{
    public function saveForm()
    {
        $completedFormManager = new CompletedFormManager();
        $respSessionManager = new ResponseSessionManager(); // cette variable s'appelait $responseSessionManager
        // mais phpmd la trouvait trop longue
        if (isset($_SESSION['user_id'])) {
            $user = $_SESSION['user_id'];
        } else {
            $user = $respSessionManager->createUnknownUser();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sentForm = array_map('trim', $_POST);
            foreach ($sentForm as $key => $formResponse) {
                $responseArray = explode('_', $key);
                $toolFormId = intval($responseArray[0]);

                if ($formResponse === 'on') {
                    $response = implode('_', $responseArray);
                } else {
                    $response = $formResponse;
                }

                $sessionId = $respSessionManager->insert($toolFormId, $user);
                $completedFormManager->insert($sessionId, $response);
            }
        }
        return $this->twig->render('Form/thanks.html.twig');
    }
}
