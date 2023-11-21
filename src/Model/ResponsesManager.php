<?php

namespace App\Model;

use PDO;

class ResponsesManager extends AbstractManager
{
    public const TABLE = 'completed_form';


    public function getResponses($username)
    {
        $query = "SELECT username, name, label, value, response_session.user_id
        FROM completed_form
        JOIN response_session ON response_session.id = completed_form.response_session_id
        JOIN tool_form ON response_session.tool_form_id = tool_form.id
        JOIN form ON tool_form.form_id = form.id   
        JOIN user ON form.user_id = user.id
        WHERE username = :username
        ORDER BY response_session.user_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
        $responses = $statement->fetchAll();

        return $responses;
    }

    public function getNbResponders($formId)
    {
        $query = "SELECT COUNT(DISTINCT response_session.user_id) as nb_responses
                    FROM response_session
                    JOIN tool_form ON response_session.tool_form_id = tool_form.id
                    JOIN form ON form.id = tool_form.form_id
                    WHERE form.id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $formId, \PDO::PARAM_INT);
        $statement->execute();
        $response = $statement->fetch();

        return $response;
    }

    public function getResponders($formId)
    {
        $query = "SELECT DISTINCT response_session.user_id
        FROM response_session
        JOIN tool_form ON response_session.tool_form_id = tool_form.id
        JOIN form ON form.id = tool_form.form_id
        WHERE form.id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $formId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
