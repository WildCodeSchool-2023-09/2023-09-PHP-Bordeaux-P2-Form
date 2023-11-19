<?php

namespace App\Model;

class CSVManager
{
    private const CSVDIR = 'assets/csv/';

    public function createCSVFile(int $formId): void
    {
        $fileName = $this->createCSVName($formId);

        $fileToWrite = fopen($fileName, "w");

        $data = $this->getDataForCSV($formId);
        if (count($data) > 0) {
            $columns = array_keys($data[0]);
            $columnsToWrite = implode(";", $columns) . PHP_EOL;
            fwrite($fileToWrite, $columnsToWrite);
            // écrire dans le fichier
            foreach ($data as $response) {
                $responseToWrite = implode(";", $response) . PHP_EOL;
                fwrite($fileToWrite, $responseToWrite);
            }
        }

        fclose($fileToWrite);
    }

    public function createCSVName(int $formId): string
    {
        return self::CSVDIR . 'formResponse' . $formId . '.csv';
    }

    public function getDataForCSV(int $formId): array
    {
        $respManager = new CompletedFormManager();
        $responses = $respManager->getResponsesForCSV($formId);
        return $responses;
    }

    public function getDataForView($formId): array
    {
        $data = [];
        $data = [$formId]; // line just for grumphp, the method will be implement later or erase

        return $data;
    }
}
