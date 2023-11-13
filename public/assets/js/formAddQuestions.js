const buttonDisplayTypeMenu = document.getElementById("displayTypeMenu");
const buttonCloseTypeMenu = document.getElementById("closeTypeMenu");

buttonDisplayTypeMenu.addEventListener("click", (event) => {
    /* askNewQuestion(); */
    displayTypeMenu();
});

buttonCloseTypeMenu.addEventListener("click", () => {
    displayTypeMenu();
});

const typeText = document.getElementById("typeText");
const typeRadio = document.getElementById("typeRadio");
const typeCheckbox = document.getElementById("typeCheckbox");
const typeRange = document.getElementById("typeRange");

typeText.addEventListener("click", () => {
    askNewQuestion();
});

typeRadio.addEventListener("click", () => {
    askNewMultipleQuestion("radio");
});
typeCheckbox.addEventListener("click", () => {
    askNewMultipleQuestion("checkbox");
});
typeRange.addEventListener("click", () => {
    askNewRangeQuestion();
});

//a valider
const divQuestions = document.getElementById("questions");

const buttonsUp = document.getElementsByClassName("buttonUp");
const buttonsDown = document.getElementsByClassName("buttonDown");

/* menu for input type*/

const addQuestionMenu = document.getElementById("menu-add-question");
const buttonCloseAddMenu = document.getElementById("closeAddMenu");

let questionsNb = 0;

buttonCloseAddMenu.addEventListener("click", () => {
    closeAddQuestionMenu();
});
