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
            $errors += $this->verifyQuestion($question);
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
        $errors = [];
        $label = false;
        $order = false;
        $type = false;
        $toolid = false;
        foreach ($question as $key => $value) {
            if (is_string($value) || (is_int($value))) {
                $value = trim($value);
                $question[$key] = $value;
            } else {
                foreach ($value as $proposition) {
                    $errors += $this->verifyPropositions($proposition);
                }
            }
            if ($key === 'label') {
                $label = true;
                $errors += $this->verifyString($value, 'label');
            }
            if ($key === 'type') {
                $type = true;
                $errors += $this->verifyType($value);
            }
            if ($key === 'toolid' || $key === 'order') {
                $$key = true;
                $errors += $this->verifyInt($value, 'toolid');
            }
        }

        $errors += $this->verifyQuestionKeys($label, $order, $type, $toolid);

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

    public function verifyPropositions($proposition)
    {
        $errors = [];
        if (isset($proposition['value'])) {
            $errors += $this->verifyString(
                $proposition['value'],
                'valeur de la proposition'
            );
        } else {
            $errors['value'] = 'La valeur de la proposition n\'existe pas';
        }
        if (isset($proposition['order'])) {
            $errors += $this->verifyInt(
                $proposition['order'],
                'ordre de la proposition'
            );
        } else {
            $errors['order'] = 'L\'ordre de la proposition n\'existe pas';
        }
        if (isset($proposition['propositionId'])) {
            $errors += $this->verifyInt(
                $proposition['propositionId'],
                'id de la proposition'
            );
        } else {
            $errors['propositionId'] = 'L\'id de la proposition n\'existe pas';
        }

        return $errors;
    }

    public function verifyRange($question)
    {
        $errors = [];
        $parameters = ['min', 'max', 'step'];
        var_dump($question);
        foreach ($parameters as $parameter) {
            if (!isset($question[$parameter])) {
                $errors[$parameter . 'Range'] = 'la valeur ' . $parameter . ' n\'existe pas.';
            } elseif (!is_numeric($question[$parameter])) {
                $errors[$parameter . 'Range'] = 'la valeur ' . $parameter . ' n\'est pas numérique.';
            }
        }
        if (empty($errors)) {
            if ($question['step'] == 0) { // simple equality
                $errors['step'] = 'le step ne peut pas être égal à 0';
            }
        }
        if (empty($errors)) {
            $errors += $this->verifyRangeParameters($question);
        }

        return $errors;
    }

    public function verifyRangeParameters(array $question): array
    {
        $errors = [];

        if ($question['min'] > $question['max'] && $question['step'] > 0) {
            $errors['step'] = 'le min ne peut pas être supérieur au max si le step est positif';
        } else {
            if ($question['min'] < $question['max'] && $question['step'] < 0) {
                $errors['step'] = 'le min ne peut pas être inférieur au max si le step est négatif';
            }
        }

        return $errors;
    }
}
