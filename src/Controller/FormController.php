<?php

namespace App\Controller;

use App\Model\FormManager;

class FormController extends AbstractController
{
    /**
     * Show informations for a specific item
     */
    public function index(): string
    {
        $userId = $_SESSION['user_id'];
        $formManager = new FormManager();
        $forms = $formManager->selectAllByUserId($userId);

        return $this->twig->render('Form/index.html.twig', ['forms' => $forms]);
    }

    public function createForm(int $id): string
    {
        $formManager = new FormManager();
        if (!is_numeric($id)) {
            $errors = ["Un problème est survenu dans la matrice"];
        }
        $form = $formManager->selectOneById($id);
        if (!$form) {
            $errors = ['Le formulaire demandé n\'existe pas'];
        }
        if ($form['user_id'] !== $_SESSION['user_id']) {
            $errors = ['Vous n\'avez pas accès à cette ressource.'];
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('location: error');
            exit();
        }


        return $this->twig->render('Form/create.html.twig', ['form' => $form]);
    }

    public function chooseName(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formName = '';
            if (isset($_POST['formName'])) {
                $formName = trim($_POST['formName']);
                if (empty($formName)) {
                    $errors[] = 'Le nom du formulaire ne doit pas être vide.';
                }
                if (strlen($formName) > 255) {
                    $errors[] = 'Le nom du formulaire doit comporter au maximum 255 caractères.';
                }
            } else {
                $errors[] = 'Veuillez choisir un nom pour votre formulaire.';
            }
            if (empty($errors)) {
                $formManager = new FormManager();
                $result = $formManager->createForm($formName);

                header('location: createForm?id=' . $result);
                exit();
            }
        }

        return $this->twig->render('Form/chooseName.html.twig', ['errors' => $errors]);
    }
}
