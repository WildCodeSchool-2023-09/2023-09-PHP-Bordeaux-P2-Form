<?php

namespace App\Model;

use PDO;

class ChoiceManager extends AbstractManager
{
    public const TABLE = 'choice';

    public function getChoices(int $formId): array
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE tool_form_id = :tool_form_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('tool_form_id', $formId, PDO::PARAM_INT);
        $statement->execute();

        $returns = $statement->fetchAll();

        return $returns;
    }
}
