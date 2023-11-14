<?php

namespace App\Model;

use PDO;

class ResponsesManager extends AbstractManager
{
    public const TABLE = 'completed_form';

    public function getResponses($responseSessionId)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE response_session_id = :response_session_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':response_session_id', $responseSessionId, \PDO::PARAM_STR);
        $statement->execute();
        $response = $statement->fetch();

        return $response;
    }
}
  //  {
   //     $statement = $this->connection->query('SELECT id, title FROM recipe');
    //    $recipes = $statement->\PDO::FETCH_ASSOC

   //     return $recipes;
