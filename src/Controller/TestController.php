<?php

namespace App\Controller;

use App\Model\CSVManager;
use App\Model\DataViewManager;

class TestController extends AbstractController
{
    /**
     * Display home page
     */
    public function test(): string
    {
        $dataManager = new DataViewManager();

        $array = $dataManager->getData(7);

        return $this->twig->render('Form/test.html.twig', ['array' => $array]);
    }
}
