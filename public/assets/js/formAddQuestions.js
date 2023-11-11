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

typeText.addEventListener("click", () => {
    askNewQuestion();
});

typeRadio.addEventListener("click", () => {
    askNewMultipleQuestion("radio");
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
