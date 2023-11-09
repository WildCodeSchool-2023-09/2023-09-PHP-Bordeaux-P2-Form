const title = document.getElementById("formTitle");

const buttonAdd = document.getElementById("addAQuestion");
const buttonClose = document.getElementById("closeMenu");

const divQuestions = document.getElementById("questions");
const divSavedQuestions = document.getElementById("savedQuestions");

const validateQuestionsCollection =
    document.getElementsByClassName("validateQuestion");
const buttonsSuppr = document.getElementsByClassName("buttonSuppr");
const buttonsUp = document.getElementsByClassName("buttonUp");
const buttonsDown = document.getElementsByClassName("buttonDown");
const changeInputs = document.getElementsByClassName("savedQuestion");

/* menu for input type*/
const typeText = document.getElementById("typeText");

const questionsList = new Questions();
let questionsNb = 0;

fromPHP = JSON.parse(fromPHP);
fromPHP = JSON.parse(fromPHP);

questionsList.addFromArray(fromPHP);
updateForms();

typeText.addEventListener("click", () => {
    askNewQuestion();
    displayTypeMenu();
});

buttonAdd.addEventListener("click", (event) => {
    /* askNewQuestion(); */
    displayTypeMenu();
});
buttonClose.addEventListener("click", () => {
    displayTypeMenu();
});

title.addEventListener("input", () => {
    document.getElementById("title").value = title.innerText;
});
