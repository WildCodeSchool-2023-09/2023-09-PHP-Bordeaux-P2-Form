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

        return $this->prepareCharts($data);
    }

    public function prepareCharts($data)
    {
        foreach ($data['questions'] as $key => $question) {
            /* if (!empty($question['question_type'] && $question['question_type'] == 'radio')) {
                $data['questions'][$key]['dataPoints'] = $this->preparePieChart($question['choices']);
            } */
            if ($question['question_type'] == 'radio' || $question['question_type'] == 'checkbox') {
                $data['questions'][$key]['dataPoints'] = $this->preparePieChart($question['choices']);
            } elseif ($question['question_type'] == 'range') {
                $data['questions'][$key]['dataPoints'] = $this->prepareRangeChart($question);
                $data['questions'][$key]['average'] = $this->calcAverage($question['choices']);
            }
        }
        // echo '<pre>';
        // print_r($data);
        // echo '<pre>';
        return $data;
    }

    public function preparePieChart(array $datas): array
    {
        $dataPoints = [];
        foreach ($datas as $key => $data) {
            $dataPoints['labels'][] = $key;
            $dataPoints['data'][] = $data;
        }
        // $callback = function ($key, $value) {
        //     $result['labels'][] = $key;
        //     $result['values'][] = $value;
        //     return $result;
        // };
        // $dataPoints = array_map($callback, array_keys($datas), $datas);

        return $dataPoints;
    }

    public function prepareRangeChart($question): array
    {
        $result = [];
        $savedFormManager = new SavedFormManager();
        $choices = $savedFormManager->selectChoice($question['id']);
        [$min, $max, $step] = array_map(fn ($arr) => $arr['tool_option'], $choices);
        $map = array_fill_keys(range($min, $max, $step), 0);


        foreach ($question['choices'] as $key => $value) {
            $map[$key] = $value;
        }
        // $callback = function ($key, $value) {
        //     $result['labels'][] = $key;
        //     $result['values'][] = $value;
        // };
        // $result = array_map($callback, array_keys($question['choices']), $question['choices']);

        foreach ($map as $x => $y) {
            $result['labels'][] = $x;
            $result['values'][] = $y;
        }
        return $result;
    }

    public function calcAverage(array $choices)
    {
        $total = 0;
        $totalNb = 0;
        foreach ($choices as $value => $nb) {
            $total += $nb * $value;
            $totalNb += $nb;
        }
        return round($total / $totalNb, 2);
    }
}
