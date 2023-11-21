<?php

namespace App\Model;

use PDO;

class ToolFormManager extends AbstractManager
{
    public const TABLE = 'tool_form';

    public function getTools(int $formId)
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE form_id = :form_id';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('form_id', $formId, PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }

    public function add(int $formId, array $tool): int
    {
        $query = "INSERT INTO " . self::TABLE . " (form_id, tool_input_id, order_tool, label)
        VALUES (:form_id, :tool_input_id, :order_tool, :label)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('form_id', $formId, PDO::PARAM_INT);
        $statement->bindValue('tool_input_id', $tool['type'], PDO::PARAM_INT);
        $statement->bindValue('order_tool', $tool['order'], PDO::PARAM_INT);
        $statement->bindValue('label', $tool['label'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $tool): int
    {
        $query = "UPDATE " . self::TABLE .
            " SET tool_input_id = :tool_input_id, order_tool = :order_tool, label = :label WHERE id=:id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $tool['toolid'], PDO::PARAM_INT);
        $statement->bindValue('tool_input_id', $tool['type'], PDO::PARAM_INT);
        $statement->bindValue('order_tool', $tool['order'], PDO::PARAM_INT);
        $statement->bindValue('label', $tool['label'], PDO::PARAM_STR);

        $statement->execute();
        return $tool['toolid'];
    }


    public function compareBeforeDelete(int $formId, array $questions): array
    {
        $tools = $this->getTools($formId);
        $toDelete = [];
        $notToDelete = [];
        foreach ($tools as $tool) {
            $toDelete[] = $tool['id'];
        }
        foreach ($questions as $question) {
            $notToDelete[] = $question['toolid'];
        }
        return array_diff($toDelete, $notToDelete);
    }

    public function addUpdateDelete(int $formId, array $questions): void
    {
        foreach ($this->compareBeforeDelete($formId, $questions) as $deleteId) {
            $this->delete($deleteId);
        }

        foreach ($questions as $question) {
            if ($question['toolid'] === -1) {
                $toolId = $this->add($formId, $question);
            } else {
                $toolId = $this->update($question);
            }
            if (isset($question['propositions'])) {
                $choiceManager = new ChoiceManager();
                $choiceManager->addUpdateDelete($toolId, $question['propositions']);
            }
            if (isset($question['range'])) {
                $choiceManager = new ChoiceManager();
                $choiceManager->addUpdateDelete($toolId, $question['range']);
            }
        }
    }

    public function getQuestions(int $formId)
    {
        $query = "SELECT tool_form.id, tool_form.label, tool_input.name AS question_type FROM tool_form
                    JOIN tool_input ON tool_input.id = tool_form.tool_input_id
                    WHERE tool_form.form_id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $formId, PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }
}
