<?php

namespace App\Model;

use PDO;

class ResponsesManager extends AbstractManager
{
    public const TABLE = 'completed_form';

  //  public function getResponses($responseSessionId) ************
//   {
  //      $query = "SELECT * FROM " . self::TABLE . " WHERE response_session_id = :response_session_id;";
    //    $statement = $this->pdo->prepare($query);
      //  $statement->bindValue(':response_session_id', $responseSessionId, \PDO::PARAM_STR);
        //$statement->execute();
        //$response = $statement->fetch();
//
    //    return $response;


    public function getResponses($userId)
    {
        $query = "SELECT value, label, user_id
        FROM completed_form
        JOIN response_session ON response_session.id = completed_form.response_session_id
        JOIN tool_form ON response_session.tool_form_id = tool_form.id
        WHERE user_id = :user_id;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_STR);
        $statement->execute();
        $response = $statement->fetch();

        return $response;
    }
}
