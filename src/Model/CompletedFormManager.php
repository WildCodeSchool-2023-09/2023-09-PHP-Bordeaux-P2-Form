<?php

namespace App\Model;

use PDO;

class CompletedFormManager extends AbstractManager
{
    public const TABLE = 'completed_form';

    public function insert(int $responseSessionId, string $value): int
    {
        $query = "INSERT INTO " . self::TABLE . " (response_session_id, value) VALUES (:response_session_id, :value)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('response_session_id', $responseSessionId, PDO::PARAM_INT);
        $statement->bindValue('value', $value, PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function getResponses($formId): array
    {
        $query = "SELECT response_session.user_id, tool_form.label AS question, completed_form.value AS response
                    FROM completed_form
                    JOIN response_session ON completed_form.response_session_id = response_session.id
                    JOIN tool_form ON tool_form.id = response_session.tool_form_id
                    JOIN form ON form.id=tool_form.form_id
                    WHERE form_id = :id
                    ORDER BY response_session.user_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $formId, PDO::PARAM_INT);
        $statement->execute();

        $returns = $statement->fetchAll();

        return $returns;
    }
}
