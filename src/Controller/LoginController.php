<?php

namespace App\Controller;

use App\Model\LoginManager;
use App\Controller\SuccessController;
use Symfony\Component\Config\Definition\Builder\ValidationBuilder;

class LoginController extends AbstractController
{
    public function login(): ?string
    {
        $errors = [];
        $email = null;
        $password = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email'])) {
                $email = trim($_POST['email']);
                if (empty($email)) {
                    $errors['email'] = 'Email requis';
                }
            } else {
                $errors['email'] = 'Email requis';
            }

            if (isset($_POST['password'])) {
                $password = trim($_POST['password']);
                if (empty($password)) {
                    $errors['password'] = 'Mot de passe requis';
                }
            } else {
                $errors['password'] = 'Mot de passe requis';
            }

            if (empty($errors)) {
                $loginManager = new LoginManager();
                $user = $loginManager->getUser($email);
                if (!empty($user)) {
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        header("Location: /");
                        exit();
                    } else {
                        $errors['password'] = 'Mot de passe incorrect';
                        // this is still not displaing correctly
                    }
                } else {
                    $errors['email'] = 'Utilisateur non trouvé';
                }
            }
        }
        return $this->twig->render('User/login.html.twig', [
            'errors' => $errors
        ]);
    }

    public function logout(): void
    {
        $this->unsetsession();
        header('Location: /');
    }

    public function unsetSession(): void
    {
        $_SESSION = array();
        session_destroy();
        unset($_SESSION);
    }
}
