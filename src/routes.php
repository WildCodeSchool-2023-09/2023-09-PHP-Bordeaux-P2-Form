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
    'isEmailTaken' => ['RegisterController', 'isEmailTaken',],
    'isUsernameTaken' => ['RegisterController', 'isUsernameTaken',],
    'passwordMatch' => ['RegisterController', 'passwordMatch',],
    'InvalidEmail' => ['RegisterController', 'InvalidEmail',],
    'emptyInput' => ['RegisterController', 'emptyInput',],
    'verifyPassword' => ['RegisterController', 'verifyPassword',],
    'verifyUsername' => ['RegisterController', 'verifyUsername',],

    'forms' => ['FormController', 'index'],
    'chooseName' => ['FormController', 'chooseName'],
    'modifyForm' => ['FormController', 'modifyForm', ['id']],
    'error' => ['HomeController', 'error'],
    'test' => ['TestController', 'test'],
    'delete' => ['FormController', 'delete', ['id']],
    'validForm' => ['FormController', 'validForm', ['id']],

    'saved' => ['SavedFormController', 'show', ['id']], // affichage formulaire
    'responses' => ['DataViewController', 'responses',],
    'responseToForm' => ['SaveResponseController', 'saveForm', ['id']],
    'thanks' => ['SaveResponseController', 'thanks'],
    'alreadyAnswered' => ['SaveResponseController', 'already'],
   'errors' => ['SaveResponseController', 'errors'],
    'verifyResponses' => ['SaveResponseController', 'verifyResponses'],
    'charts' => ['DataViewController', 'index', ['id']],
];
