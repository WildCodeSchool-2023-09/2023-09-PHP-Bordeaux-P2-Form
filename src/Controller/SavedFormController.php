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

        $savedFormManager = new SavedFormManager();

        $formName = $savedFormManager->selectFormNameById($id);
        //var_dump($formName);

        $savedForm = $savedFormManager->selectQuestion($id);
        foreach ($savedForm as $key => $question) {
            if ($question ['question_type'] != "text") {
                $savedForm[$key]['choice'] = $savedFormManager->selectChoice($question['id']);
        //var_dump($savedForm[$key]['choice']);
            }
            $savedForm[$key]['question_name'] = $this->transformSentence($savedForm[$key]['Question']);
        }
        //var_dump($savedForm);

        return $this->twig->render('Form/show_savedForm.html.twig', [
            'savedForm' => $savedForm,
            'formName' => $formName
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

}
