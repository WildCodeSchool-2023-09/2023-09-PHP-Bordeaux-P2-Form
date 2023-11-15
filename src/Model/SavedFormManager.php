<?php

namespace App\Model;

use PDO;

class SavedFormManager extends AbstractManager
{
    public function selectQuestion(int $idForm): array
    {
        $query = "SELECT tool_form.order_tool AS Number_Q, tool_form.label AS Question, 
        tool_form.id, tool_input.name as question_type 
        FROM tool_form
        JOIN form ON form.id = tool_form.form_id
        JOIN tool_input ON tool_input.id = tool_form.tool_input_id
        WHERE form.id = :id
        ORDER BY tool_form.order_tool";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $idForm, \PDO::PARAM_INT);
        $statement->execute();
        //var_dump($query);

        return $statement->fetchAll();
    }

    public function selectChoice(int $toolFormId): array
    {

        $query = "SELECT choice_order, tool_option 
        FROM choice 
        WHERE tool_form_id = :toolformId";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':toolformId', $toolFormId, \PDO::PARAM_INT);
        $statement->execute();
         var_dump($query);

        return $statement->fetchAll();
    }

    public function selectFormNameById(int $formId): array
    {
        $query = "SELECT form.name
        FROM form
        WHERE form.id = :formId";

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':formId', $formId, \PDO::PARAM_INT);
        $statement->execute();
        //var_dump($query);
        return $statement->fetch();
    }


    public function selectOneById(int $id): array|false
    {
        //$query = "SELECT * FROM form WHERE id=:id";

        $query = "SELECT f.name AS nom_formulaire, tf.label AS question, 
        ti.name AS type_Question, c.tool_option AS choix
        FROM form f
        JOIN tool_form tf ON f.id = tf.form_id
        JOIN tool_input ti ON tf.tool_input_id = ti.id
        LEFT JOIN choice c ON tf.id = c.tool_form_id
        WHERE f.id = :id
        ORDER BY tf.order_tool";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
      //var_dump($query);

        return $statement->fetchAll();
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
