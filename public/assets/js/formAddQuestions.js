const title = document.getElementById("formTitle");

const buttonAdd = document.getElementById("addAQuestion");
const divQuestions = document.getElementById("questions");
const divSavedQuestions = document.getElementById("savedQuestions");

const validateQuestionsCollection =
    document.getElementsByClassName("validateQuestion");
const buttonsSuppr = document.getElementsByClassName("buttonSuppr");
const buttonsUp = document.getElementsByClassName("buttonUp");
const buttonsDown = document.getElementsByClassName("buttonDown");
const changeInputs = document.getElementsByClassName("savedQuestion");

const questionsList = new Questions();
let questionsNb = 0;

fromPHP = JSON.parse(fromPHP);
fromPHP = JSON.parse(fromPHP);

questionsList.addFromArray(fromPHP);
updateForms();

buttonAdd.addEventListener("click", (event) => {
    questionsNb = questionsList.array.length + 1;
    divQuestions.innerHTML +=
        "<div>Quel est le titre de votre question numéro " +
        questionsNb +
        " ?<input type='text' id='question" +
        questionsNb +
        "'><button class='validateQuestion' id='validateQuestion" +
        questionsNb +
        "'>+</button></div>";

    document.getElementById("question" + questionsNb).focus();
    updateForms();
});

title.addEventListener("input", () => {
    document.getElementById("title").value = title.innerText;
});
