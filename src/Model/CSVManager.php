<?php

namespace App\Model;

class CSVManager
{
    private const CSVDIR = 'assets/csv/';

    public function createCSVFile(int $formId)
    {
        $fileName = $this->createCSVName($formId);

        $fileToWrite = fopen($fileName, "w");

        $data = $this->getData($formId);
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

    public function getData($formId): array
    {
        $respManager = new CompletedFormManager();
        $responses = $respManager->getResponses($formId);
        return $responses;
    }
}
