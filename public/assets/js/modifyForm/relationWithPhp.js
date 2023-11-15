const questionsList = new Questions();

const divSavedQuestions = document.getElementById("savedQuestions");

fromPHP = JSON.parse(fromPHP);
fromPHP = JSON.parse(fromPHP); // le deuxième est nécessaire sinon le json est mal parsé

questionsList.addFromArray(fromPHP);
updateForms();

function updateForms() {
    questionsList.display(divSavedQuestions);
    //listenAddMultipleQuestion();
    listenAddQuestion();
    listenSuppr();
    listenChange();
    listenAddProposition();
    listenSupprProposition();
    document.getElementById("formContent").value =
        JSON.stringify(questionsList);
}
