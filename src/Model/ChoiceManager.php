<?php

namespace App\Model;

use PDO;

class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';

    public function getChoices(int $toolFormId): array
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE tool_form_id = :tool_form_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('tool_form_id', $toolFormId, PDO::PARAM_INT);
        $statement->execute();

        $returns = $statement->fetchAll();

        return $returns;
    }

    public function add(int $toolId, array $proposition): int
    {
        $query = "INSERT INTO " . self::TABLE . " (tool_form_id, tool_option, order)
        VALUES (:tool_input_id, :tool_option, :order)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('tool_form_id', $toolId, PDO::PARAM_INT);
        $statement->bindValue('tool_option', $proposition['value'], PDO::PARAM_STR);
        $statement->bindValue('order', $proposition['order'], PDO::PARAM_INT);


        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $proposition): void
    {
        $query = "UPDATE " . self::TABLE .
            " SET order = :order, tool_option = :tool_option WHERE id=:id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $proposition['propositionId'], PDO::PARAM_INT);
        $statement->bindValue('tool_option', $proposition['value'], PDO::PARAM_INT);
        $statement->bindValue('order', $proposition['order'], PDO::PARAM_INT);

        $statement->execute();
    }

    public function compareBeforeDelete(int $toolFormId, array $questions): array
    {
        $tools = $this->getChoices($toolFormId);
        $toDelete = [];
        $notToDelete = [];
        foreach ($tools as $tool) {
            $toDelete[] = $tool['id'];
        }
        foreach ($questions as $question) {
            $notToDelete[] = $question['propositionId'];
        }
        return array_diff($toDelete, $notToDelete);
    }

    public function addUpdateDelete(int $toolId, array $propositions): void
    {
        foreach ($this->compareBeforeDelete($toolId, $propositions) as $deleteId) {
            $this->delete($deleteId);
        }

        foreach ($propositions as $proposition) {
            if ($proposition['propositionId'] === -1) {
                $this->add($toolId, $proposition);
            } else {
                $this->update($proposition);
            }
        }
    }
}
