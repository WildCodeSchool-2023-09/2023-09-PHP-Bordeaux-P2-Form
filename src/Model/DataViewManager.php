<?php

namespace App\Model;

use Symfony\Component\Console\Question\Question;

class DataViewManager
{
    public function getData(int $formId)
    {
        $data = [];
        $questionsManager = new ToolFormManager();
        $savedFormManager = new SavedFormManager();
        $compFormManager = new CompletedFormManager();
        $responsesManager = new ResponsesManager();
        $choiceManager = new ChoiceManager();

        $data['title'] = $savedFormManager->selectFormNameById($formId)['name'];
        $data['nb_responses'] = $responsesManager->getNbResponders($formId)['nb_responses'];
        $questions = $questionsManager->getQuestions($formId);
        foreach ($questions as $key => $question) {
            $data['questions'][$key] = $question;
            if ($question['question_type'] != 'text') {
                $choices = array_map(fn ($arr) => $arr['tool_option'], $choiceManager->getChoices($question['id']));
                foreach ($choices as $choice) {
                    $data['questions'][$key]['choices'][$choice] = 0;
                }
                //$data[$key]['question']['choices'] = array_map(fn ($arr) => $arr['tool_option'],
                //                                      $choiceManager->getChoices($question['id']));
            }

            //var_dump($question['id']);
            $responses = $compFormManager->getResponsesForQuestion($question['id']);
            //var_dump($responses);
            //$data[$key]['question']['responses'] = $compFormManager->getResponsesForQuestion($question['id']);
            foreach ($responses as $response) {
                $data['questions'][$key]['choices'][$response['value']] = $response['nb'];
            }
            //$test = array_map(fn ($value) => [$value['value'] => $value['nb']], $responses);
            //var_dump($test);
        }

        $data = $this->prepareCharts($data);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        return $data;
    }

    public function prepareCharts($data)
    {
        foreach ($data['questions'] as $key => $question) {
            /* if (!empty($question['question_type'] && $question['question_type'] == 'radio')) {
                $data['questions'][$key]['dataPoints'] = $this->preparePieChart($question['choices']);
            } */
            $data['questions'][$key]['dataPoints'] = $this->preparePieChart($question['choices']);
        }

        return $data;
    }

    public function preparePieChart(array $datas)
    {
        $dataPoints = [];
        foreach ($datas as $key => $data) {
            $dataPoints['labels'][] = $key;
            $dataPoints['data'][] = $data;
        }
        //$dataPoints = json_encode($dataPoints, JSON_NUMERIC_CHECK);
        return $dataPoints;
    }
}
