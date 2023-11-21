<?php

namespace App\Controller;

use App\Model\DataViewManager;

class DataViewController extends AbstractController
{
    public function index(int $formId): string
    {
        $dataManager = new DataViewManager();

        $array = $dataManager->getData($formId);

        return $this->twig->render('Form/test.html.twig', ['array' => $array]);
    }
}
