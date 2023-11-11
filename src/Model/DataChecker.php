<?php

namespace App\Model;

class DataChecker
{
    public function decodeJson(string $input): array
    {
        $errors = [];
        $fromJSON = json_decode($input, true);
        $questions = $fromJSON['array'];

        foreach ($questions as $question) {
            $errors = array_merge($errors, $this->verifyQuestion($question));
            if (empty($errors)) {
                foreach ($question as $key => $value) {
                    if (is_string($value)) {
                        $question[$key] = trim($value);
                    }
                }
            }
        }

        return ['questions' => $questions, 'errors' => $errors];
    }

    public function verifyInt(string $value, string $verified): ?array
    {
        $errors = [];
        if (empty($value)) {
            $errors[] = 'Le ' . $verified . ' est vide';
        } elseif (!is_numeric($value)) {
            $errors[] = 'Le ' . $verified . ' n\'est pas numérique';
        }
        return $errors;
    }

    public function verifyString(string $value, string $verified): ?array
    {
        $errors = [];
        if (empty($value)) {
            $errors[] = 'Le ' . $verified . ' ne peut pas être vide';
        } elseif (strlen($value) > 255) {
            $errors[] = 'Le ' . $verified . ' ne doit pas faire plus de 255 caractères';
        }
        return $errors;
    }

    public function verifyType(string $value): ?array
    {
        $errors = [];
        $toolInputManager = new ToolInputManager();
        $inputs = $toolInputManager->getNameId();
        if (empty($value)) {
            $errors[] = 'Un type ne peut pas être vide';
        } elseif (!isset($inputs[$value])) {
            $errors[] = 'Le type d\'input est inconnu';
        }
        return $errors;
    }

    public function verifyQuestion(array $question): ?array
    {
        //var_dump($question);
        $errors = [];
        $label = false;
        $order = false;
        $type = false;
        $toolid = false;
        foreach ($question as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
                $question[$key] = $value;
            }
            if ($key === 'label') {
                $label = true;
                $result = $this->verifyString($value, 'label');
                $errors = $this->mergeArrays($errors, $result);
            }
            if ($key === 'type') {
                $type = true;
                $result = $this->verifyType($value);
                $errors = $this->mergeArrays($errors, $result);
            }
            if ($key === 'toolid' || $key === 'order') {
                $$key = true;
                $result = $this->verifyInt($value, 'toolid');
                $errors = $this->mergeArrays($errors, $result);
            }
        }
        $errors = $this->mergeArrays($errors, $this->verifyQuestionKeys($label, $order, $type, $toolid));

        return $errors;
    }

    public function verifyQuestionKeys(bool $label, bool $order, bool $type, bool $toolid): ?array
    {
        $errors = [];
        if (!($label || $order || $type || $toolid)) {
            $errors[] = "Une erreur est survenue.";
        }
        return $errors;
    }

    /**
     * Merge arrays. If an argument is null, ignore it
     *
     * @param array|null ...$arrays
     * @return array
     */
    public function mergeArrays(?array ...$arrays): array
    {
        $result = [];
        foreach ($arrays as $array) {
            if ($array !== null) {
                $result = array_merge($result, $array);
            }
        }
        return $result;
    }

    public function verifyPropositions($question)
    {
        //todo
        return $question;
    }
}
