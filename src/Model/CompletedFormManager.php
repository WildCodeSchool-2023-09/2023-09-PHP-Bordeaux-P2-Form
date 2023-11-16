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
}
