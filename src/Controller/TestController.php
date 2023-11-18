<?php

namespace App\Controller;

use App\Model\CSVManager;

class TestController extends AbstractController
{
    /**
     * Display home page
     */
    public function test(): string
    {
        $csvManager = new CSVManager();

        $array = $csvManager->getData(5);

        $csvManager->createCSVFile(1);
        return $this->twig->render('Form/test.html.twig', ['array' => $array]);
    }
}
