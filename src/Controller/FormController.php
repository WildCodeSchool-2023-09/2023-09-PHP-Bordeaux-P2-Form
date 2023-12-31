<?php

namespace App\Controller;

use App\Model\ChoiceManager;
use App\Model\CSVManager;
use App\Model\DataChecker;
use App\Model\FormManager;
use App\Model\ResponsesManager;
use App\Model\ToolFormManager;
use App\Model\ToolInputManager;

class FormController extends AbstractController
{
    /**
     * Show informations for a specific item
     */
    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('location: login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        $formManager = new FormManager();
        $forms = $formManager->selectAllByUserId($userId);
        $responsesManager = new ResponsesManager();
        $csvManager = new CSVManager();

        foreach ($forms as $key => $form) {
            $forms[$key]['nb_responses'] = $responsesManager->getNbResponders($form['id'])['nb_responses'];
            if ($form['state']) {
                $csvManager->createCSVFile($form['id']);
            }
        }

        return $this->twig->render('Form/index.html.twig', ['forms' => $forms]);
    }

    public function modifyForm(int $id): string
    {
        $form = [];
        $tools = [];
        $errors = [];
        $formManager = new FormManager();
        $dataChecker = new DataChecker();
        $toolFormManager = new ToolFormManager();
        $choiceManager = new ChoiceManager();

        // erreurs structurelles
        if (!is_numeric($id)) {
            $errors = ["Un problème est survenu dans la matrice"];
            $this->errors($errors);
        }
        $form = $formManager->selectOneById($id);
        $tools = $toolFormManager->getTools($id);
        foreach ($tools as $key => $tool) {
            $propositions = $choiceManager->getChoices($tool['id']);
            if (!empty($propositions)) {
                $tools[$key]['propositions'] = $propositions;
            }
        }
        $this->verifyForm($form, $errors);

        // gestion du retour de formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formPost = array_map('trim', $_POST);

            // changement du titre
            if (isset($formPost['changeTitle'])) {
                $title = $formPost['title'];
                $errors += $dataChecker->verifyString($title, 'titre');

                if (empty($errors)) {
                    $formManager->updateTitle($id, $title);
                    $form['name'] = $title;
                }
            } else {
                // changement des questions
                if (!empty($formPost['formContent'])) {
                    $fromDataChecker = $dataChecker->decodeJson($formPost['formContent']);
                    $questions = $fromDataChecker['questions'];
                    $errors += $fromDataChecker['errors'];


                    if (empty($errors)) {
                        $questions = $this->changeNameAsIdInputTools($questions);
                        $toolFormManager->addUpdateDelete($id, $questions);
                        header('location: forms');
                        exit();
                    }
                } else {
                    $errors[] = 'Il faut au moins une question pour pouvoir enregistrer le formulaire.';
                }
            }
        }

        // changement des tool_input_id en string
        $tools = $this->changeIdAsNameInputTools($tools);
        $tools = json_encode($tools);

        return $this->twig->render('Form/modify.html.twig', [
            'form' => $form,    // array
            'tools' => $tools,  // JSON
            'errors' => $errors, // array
        ]);
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

                header('location: modifyForm?id=' . $result);
                exit();
            }
        }

        return $this->twig->render('Form/chooseName.html.twig', ['errors' => $errors]);
    }


    public function delete($id): void
    {
        $formManager = new FormManager();
        $formManager->delete($id);
        header('location: /forms');
        exit();
    }

    public function verifyForm($form, $errors)
    {
        if (!$form) {
            $errors = ['Le formulaire demandé n\'existe pas'];
        }
        if ($form['user_id'] !== $_SESSION['user_id']) {
            $errors = ['Vous n\'avez pas accès à cette ressource.'];
        }
        if (!empty($errors)) {
            $this->errors($errors);
        }
    }

    public function errors(array $errors): void
    {
        $_SESSION['errors'] = $errors;
        header('location: error');
        exit();
    }

    public function changeIdAsNameInputTools(array $tools): array
    {
        $toolInputManager = new ToolInputManager();
        $toolInputs = $toolInputManager->getIdName();
        foreach (array_keys($tools) as $key) {
            $tools[$key]['tool_input_id'] = $toolInputs[$tools[$key]['tool_input_id']];
        }
        return $tools;
    }

    public function changeNameAsIdInputTools(array $tools): array
    {
        $toolInputManager = new ToolInputManager();
        $toolInputs = $toolInputManager->getNameId();
        foreach (array_keys($tools) as $key) {
            $tools[$key]['type'] = $toolInputs[$tools[$key]['type']];
        }
        return $tools;
    }

    public function validForm(int $formId): void
    {
        //check if user is connected
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            //check if form exists and is link to user
            $formManager = new FormManager();
            $forms = array_map(fn ($arr) => $arr['id'], $formManager->selectAllByUserId($userId));
            if (in_array($formId, $forms)) {
                //valid form
                $formManager->validForm($formId);
                //redirect to myForms
                header('location: forms');
                exit();
            }
        }
        //redirect to home page
        $this->exit();
    }

    public function exit(): void
    {
        header('location: /');
        exit();
    }
}
