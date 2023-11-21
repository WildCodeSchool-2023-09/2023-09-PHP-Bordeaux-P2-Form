<?php

namespace App\Model;

class RegisterManager extends AbstractManager
{
    public const TABLE = 'user';


    public function setUser($username, $email, $password): int
    {
        $query = "
INSERT INTO " . self::TABLE . "(`username`, `email`, `password`) VALUES (:username, :email, :password)
";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    public function checkUser($username, $email)
    {
        $query = "SELECT username FROM " . self::TABLE . " WHERE username = :username OR email = :email;";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }


    public function isUsernameTaken($username)
    {

        $query = "SELECT * FROM  "  . self::TABLE . "   WHERE username = :username";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':username', $username, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }


    public function isEmailTaken($email)
    {

        $query = "SELECT * FROM  "  . self::TABLE . "  WHERE email = :email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }
}
