<?php

namespace App\Model;

use PDO;

class SavedFormManager extends AbstractManager
{
    public function selectOneById(int $id): array|false
    {
        $query = "SELECT * FROM form WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }


    public function getChoices(int $formId): array
    {
        $query = "SELECT * FROM choice WHERE tool_form_id = :tool_form_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('tool_form_id', $formId, PDO::PARAM_INT);
        $statement->execute();

        $returns = $statement->fetchAll();
        return $returns;
    }


    public function getTools(int $formId)
    {
        $query = 'SELECT * FROM tool_form WHERE form_id = :form_id';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('form_id', $formId, PDO::PARAM_INT);

        $statement->execute();
        return $statement->fetchAll();
    }


    public function selectNames(): array
    {
        $query = "SELECT * FROM tool_input";
        return $this->pdo->query($query)->fetchAll();
    }
}
