<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

use App\Controller\FormController;

return [
    '' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],

    'login' => ['LoginController', 'login',],
    'logout' => ['LoginController', 'logout',],
    'register' => ['RegisterController', 'register',],
    'isEmailTakenCheck' => ['RegisterController', 'isEmailTakenCheck',],
    'isUsernameTakenCheck' => ['RegisterController', 'isUsernameTakenCheck',],
    'passwordMatch' => ['RegisterController', 'passwordMatch',],
    'InvalidEmail' => ['RegisterController', 'InvalidEmail',],
    'emptyInput' => ['RegisterController', 'emptyInput',],

    'forms' => ['FormController', 'index'],
    'chooseName' => ['FormController', 'chooseName'],
    'modifyForm' => ['FormController', 'modifyForm', ['id']],
    'error' => ['HomeController', 'error'],
    'test' => ['TestController', 'test'],
    'delete' => ['FormController', 'delete', ['id']],

    'saved' => ['SavedFormController', 'show', ['id']], // affichage formulaire
    'responses' => ['ResponsesController', 'responses',],
    'responseToForm' => ['SaveResponseController', 'saveForm', ['id']],
    'thanks' => ['SaveResponseController', 'thanks'],
    'alreadyAnswered' => ['SaveResponseController', 'already'],
    'errors' => ['SaveResponseController', 'errors'],
    'verifyResponses' => ['SaveResponseController', 'verifyResponses']
];
