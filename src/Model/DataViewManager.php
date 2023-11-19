<?php

namespace App\Model;

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
            $data[$key]['question'] = $question;
            if ($question['question_type'] != 'text') {
                $choices = array_map(fn ($arr) => $arr['tool_option'], $choiceManager->getChoices($question['id']));
                foreach ($choices as $choice) {
                    $data[$key]['question']['choices'][$choice] = 0;
                }
                //$data[$key]['question']['choices'] = array_map(fn ($arr) => $arr['tool_option'],
                //                                      $choiceManager->getChoices($question['id']));
            }

            //var_dump($question['id']);
            $responses = $compFormManager->getResponsesForQuestion($question['id']);
            var_dump($responses);
            //$data[$key]['question']['responses'] = $compFormManager->getResponsesForQuestion($question['id']);
            foreach ($responses as $response) {
                $data[$key]['question']['choices'][$response['value']] = $response['nb'];
            }
            //$test = array_map(fn ($value) => [$value['value'] => $value['nb']], $responses);
            //var_dump($test);
        }

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    /* public function mergeData($toolInputId)
    {
    } */
}
