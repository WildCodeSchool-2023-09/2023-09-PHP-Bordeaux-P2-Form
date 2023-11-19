<?php

namespace App\Model;

use PDO;

class FormManager extends AbstractManager
{
    public const TABLE = 'form';

    /**
     * Insert new item in database
     */
    public function insert(array $form): int
    {
        $query = "INSERT INTO " . self::TABLE . " ('user_id', 'name') VALUES (:user_id, :name)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $form['user_id'], PDO::PARAM_INT);
        $statement->bindValue('name', $form['name'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    public function update(array $form): bool
    {
        $query = "UPDATE " . self::TABLE . " SET 'user_id' = :user_id, 'name' = :name, 'state' = :state WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $form['id'], PDO::PARAM_INT);
        $statement->bindValue('user_id', $form['user_id'], PDO::PARAM_INT);
        $statement->bindValue('name', $form['name'], PDO::PARAM_STR);
        $statement->bindValue('state', $form['state'], PDO::PARAM_BOOL);

        return $statement->execute();
    }

    public function selectAllByUserId(int $userId): array
    {

        $query = "SELECT * FROM " . self::TABLE . " WHERE user_id = :user_id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $userId, PDO::PARAM_INT);
        $statement->execute();

        $returns = $statement->fetchAll();

        return $returns;
    }

    public function createForm(string $formName): int
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (user_id, name) VALUES (:user_id, :name)';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue('user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindValue('name', $formName, PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function updateTitle(int $id, string $title): bool
    {
        $query = "UPDATE " . self::TABLE . " SET name = :name WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->bindValue('name', $title, PDO::PARAM_STR);

        return $statement->execute();
    }

    public function validForm(int $formId): bool
    {
        $query = "UPDATE " . self::TABLE . " SET state=1 WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $formId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function getAllFinished()
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE state=1';
        return $this->pdo->query($query)->fetchAll();
    }
}
