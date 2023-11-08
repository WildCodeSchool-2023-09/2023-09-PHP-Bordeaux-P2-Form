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
                $errors['username'] = $this->verifyUsername($username);
            }
            if (isset($_POST['email'])) {
                $email = trim($_POST['email']);
                $errors['email'] = $this->verifyEmail($email);
            }

            if (isset($_POST['password'])) {
                $password = trim($_POST['password']);
                $errors['password'] = $this->verifyPassword($password);
            }

            if (empty($errors) && $username && $password && $email) {
                  $register->setUser($username, $email, $password);
                  // redirect  to homepage or create form page?
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
            return 'Mot de passe requis';
        } elseif (!$this->passwordMatch($password, $_POST['passwordRepeat'])) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
    }

    private function verifyEmail(string $email)
    {
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email requis';
        }
        if (!$this->invalidEmail($email)) {
            $errors[] = "Email invalide";
        } else {
            $register = new RegisterManager();
            if ($register->isEmailTaken($email)) {
                $errors[] = "L'email existe déjà";
            }
        }
    }

    public function verifyUsername(string $username)
    {
        $errors = [];

        if (empty($username)) {
            $errors[] = "Nom d'utilisateur requis";
        }

        if ($username) {
            if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
                $errors[] = "Nom d'utilisateur invalide";
            } else {
                $register = new RegisterManager();
                if ($register->isUsernameTaken($username)) {
                    $errors[] = "Le nom d'utilisateur existe déjà";
                }
            }
        }
    }
}
