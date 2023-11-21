<?php

namespace App\Model;

use PDO;

class ResponseSessionManager extends AbstractManager
{
    public const TABLE = 'response_session';

    public function createUnknownUser(): int
    {
        $query = 'CALL create_new_user(@var)';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $stmt->closeCursor();

        $query = "SELECT @var";
        $return = $this->pdo->query($query)->fetch();
        return $return['@var'];
    }

    public function insert(int $toolFormId, int $userId): int
    {
        $query = "INSERT INTO " . self::TABLE . " (tool_form_id, user_id) VALUES (:tool_form_id, :user_id)";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('tool_form_id', $toolFormId, PDO::PARAM_INT);
        $statement->bindValue('user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
