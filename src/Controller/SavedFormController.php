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
        $savedForm = $savedFormManager->selectOneById($id);
        //var_dump($savedForm);


        return $this->twig->render('Form/show_savedForm.html.twig', ['savedForm' => $savedForm]);
    }
}
