<?php

namespace App\Model;

use PDO;

class ToolInputManager extends AbstractManager
{
    public const TABLE = 'tool_input';

    public function selectNames()
    {
        $query = $query = "SELECT * FROM " . self::TABLE;

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * get an associative array where keys are inputType id and values are inputType names
     *
     * @return array
     */
    public function getIdName(): array
    {
        $results = [];
        $toolInputs = $this->selectNames();
        foreach ($toolInputs as $toolInput) {
            $results[$toolInput['id']] = $toolInput['name'];
        }
        return $results;
    }

    /**
     * get an associative array where keys are inputType name and values are inputType id
     *
     * @return array
     */
    public function getNameId(): array
    {
        $results = [];
        $toolInputs = $this->selectNames();
        foreach ($toolInputs as $toolInput) {
            $results[$toolInput['name']] = $toolInput['id'];
        }
        return $results;
    }
}
