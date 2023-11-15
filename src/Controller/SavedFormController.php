<?php

namespace App\Controller;

use App\Model\DataChecker;
use App\Model\FormManager;
use App\Model\ToolFormManager;
use App\Model\ToolInputManager;
use App\Model\SavedFormManager;

class SavedFormController extends AbstractController
{
    public function show(int $id): string
    {
        $savedFormManager = new SavedFormManager();

        $formName = $savedFormManager->selectFormNameById($id);
        //var_dump($formName);
        $savedForm = $savedFormManager->selectQuestion($id);
        foreach ($savedForm as $key => $question) {
            if ($question ['question_type'] != "text") {
                $savedForm[$key]['choice'] = $savedFormManager->selectChoice($question['id']);
                var_dump($savedForm[$key]['choice']);
            }
        }
        //var_dump($savedForm);
        return $this->twig->render('Form/show_savedForm.html.twig', [
            'savedForm' => $savedForm,
            'formName' => $formName
        ]);
    }
}
