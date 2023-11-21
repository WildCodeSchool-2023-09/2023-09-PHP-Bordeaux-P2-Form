<?php

namespace App\Controller;

use App\Model\DataChecker;
use App\Model\FormManager;
use App\Model\ToolFormManager;
use App\Model\ToolInputManager;
use App\Model\SavedFormManager;
use App\Model\FunctionManager;

class SavedFormController extends AbstractController
{
    public function show(int $id): string
    {
        // start modif
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);
        }

        // end modif

        $savedFormManager = new SavedFormManager();

        $formName = $savedFormManager->selectFormNameById($id);
        $formName['id'] = $id;
        //var_dump($formName);

        $savedForm = $savedFormManager->selectQuestion($id);
        foreach ($savedForm as $key => $question) {
            if ($question['question_type'] != "text") {
                $savedForm[$key]['choice'] = $savedFormManager->selectChoice($question['id']);
                //var_dump($savedForm[$key]['choice']);
            }
            $savedForm[$key]['question_name'] = $this->transformSentence($savedForm[$key]['Question']);
        }

        return $this->twig->render('Form/show_savedForm.html.twig', [
            'savedForm' => $savedForm,
            'formName' => $formName,
        ]);
    }


    public function transformSentence(string $sentence): string
    {
        $search  = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î',
            'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û',
            'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï',
            'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'
        );
        $replace = array(
            'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I',
            'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c',
            'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
            'y', 'y'
        );
        $sentence = str_replace($search, $replace, $sentence);
        $iii = 0;
        while (isset($sentence[$iii])) {
            if (!preg_match('/[a-z]|[A-Z]/', $sentence[$iii])) {
                $sentence[$iii] = '_';
            }
            $iii += 1;
        }
        return trim($sentence, "_");
    }


    public function styleFormulaire($id)
    {
        $savedFormManager = new SavedFormManager();

        $formName = $savedFormManager->selectFormNameById($id);
        $formName['id'] = $id;
        //var_dump($formName);

        $savedForm = $savedFormManager->selectQuestion($id);
        foreach ($savedForm as $key => $question) {
            if ($question['question_type'] != "text") {
                $savedForm[$key]['choice'] = $savedFormManager->selectChoice($question['id']);
                //var_dump($savedForm[$key]['choice']);
            }
            $savedForm[$key]['question_name'] = $this->transformSentence($savedForm[$key]['Question']);
        }

        return $this->twig->render('Form/stylisationForm.html.twig', [
            'savedForm' => $savedForm,
            'formName' => $formName,
            'formId' => $id,
        ]);
    }

    public function stylisation()
    {
        $errors = [];
        // $police = ['arial', 'Brush Script MT', 'Comic Sans', 'Baskerville', 'Garamond', 'Georgia', 'Helvetica',
        //     'Impact', 'Palatino', 'Tahoma', 'Times New Roman', 'Trebuchet', 'Verdana'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputs =  array_map('trim', $_POST);
            if (!isset($inputs['background'])) {
                $errors[] = 'Erreur background';
            }
            if (!isset($inputs['police'])) {
                $errors[] = 'Erreur police';
            }
            if (!isset($inputs['police_color'])) {
                $errors[] = 'Erreur police_color';
            }
            if (!isset($inputs['police_size'])) {
                $errors[] = 'Erreur police_size';
            }
            if (!isset($inputs['form_id'])) {
                $errors[] = 'Erreur id';
            }
            // if (!isset($inputs['background']) || !FunctionManager::isColor($inputs['background'])) {
            //     $errors[] = 'Erreur background';
            // }
            // if (!isset($inputs['police']) || !in_array($inputs['police'], $police)) {
            //     $errors[] = 'Erreur police';
            // }
            // if (!isset($inputs['police_color']) || !FunctionManager::isColor($inputs['police_color'])) {
            //     $errors[] = 'Erreur police_color';
            // }
            // if (!isset($inputs['police_size']) || !is_numeric($inputs['police_size'])) {
            //     $errors[] = 'Erreur police_size';
            // }
            // if (!isset($inputs['form_id']) || !is_numeric($inputs['form_id'])) {
            //     $errors[] = 'Erreur id';
            // }
            if (empty($errors)) {
                $savedFormManager = new SavedFormManager();
                $savedFormManager->updateStyle($inputs);
                header('location: /stylisationForm?id=' . $inputs['form_id']);
            }
        }
    }
}
