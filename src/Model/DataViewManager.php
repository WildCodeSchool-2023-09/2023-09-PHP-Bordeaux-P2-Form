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
            }

            $responses = $compFormManager->getResponsesForQuestion($question['id']);
            foreach ($responses as $response) {
                $data['questions'][$key]['choices'][$response['value']] = $response['nb'];
            }
        }

        return $this->prepareCharts($data);
    }

    public function prepareCharts($data)
    {
        foreach ($data['questions'] as $key => $question) {
            if ($question['question_type'] == 'radio' || $question['question_type'] == 'checkbox') {
                $data['questions'][$key]['dataPoints'] = $this->preparePieChart($question['choices']);
            } elseif ($question['question_type'] == 'range') {
                $data['questions'][$key]['dataPoints'] = $this->prepareRangeChart($question);
                $data['questions'][$key]['average'] = $this->calcAverage($question['choices']);
            }
        }
        return $data;
    }

    public function preparePieChart(array $datas): array
    {
        $dataPoints = [];
        foreach ($datas as $key => $data) {
            $dataPoints['labels'][] = $key;
            $dataPoints['data'][] = $data;
        }

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
