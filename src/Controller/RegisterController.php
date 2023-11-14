<?php

namespace App\Controller;

use App\Model\RegisterManager;
use App\Controller\AbstractController;
use App\Controller\SuccessController;

class RegisterController extends AbstractController
{
    public function register()
    {
        $errors = [];
        $email = "";
        $password = "";
        $username = "";
        $register = new RegisterManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username'])) {
                $username = trim($_POST['username']);
                $errors += $this->verifyUsername($username);
            }
            if (isset($_POST['email'])) {
                $email = trim($_POST['email']);
                $errors += $this->verifyEmail($email);
            }

            if (isset($_POST['password'])) {
                $password = trim($_POST['password']);

                $errors = $this->verifyPassword($password);
            }


            if (empty($errors) && $username && $password && $email) {
                $_SESSION['user_id'] = $register->setUser($username, $email, $password);
                header('location: forms');
            }
        }


        return $this->twig->render('User/register.html.twig', ['errors' => $errors]);
    }



    private function invalidEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordMatch(string $password, string $passwordRepeat)
    {
        return $password === $passwordRepeat;
    }

    private function verifyPassword(string $password)
    {
        $errors = [];

        if (empty($password)) {
            $errors['password'] = 'Mot de passe requis';
        } elseif (!$this->passwordMatch($password, $_POST['passwordRepeat'])) {
            $errors['password'] = "Les mots de passe ne correspondent pas";
        }
        return $errors;
    }

    private function verifyEmail(string $email)
    {
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email requis';
        }
        if (!$this->invalidEmail($email)) {
            $errors['email'] = "Email invalide";
        } else {
            $register = new RegisterManager();
            if ($register->isEmailTaken($email)) {
                $errors['email'] = "L'email existe déjà";
            }
        }
        return $errors;
    }

    public function verifyUsername(string $username): array
    {
        $errors = [];

        if (empty($username)) {
            $errors['username'] = "Nom d'utilisateur requis";
        } elseif (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
            $errors['username'] = "Nom d'utilisateur invalide";
        } else {
            $register = new RegisterManager();
            if ($register->isUsernameTaken($username)) {
                $errors['username'] = "Le nom d'utilisateur existe déjà";
            }
        }

        return $errors;
    }
}
