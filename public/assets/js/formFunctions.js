function listen() {
    for (var i = 0; i < validateQuestionsCollection.length; i += 1) {
        validateQuestionsCollection[i].addEventListener("click", (e) => {
            let nb = e.target.id.slice("validateQuestion".length);
            let label = document.getElementById("question" + nb).value;
            questionsList.add(new Question(label, nb));
            e.target.parentElement.remove();
            updateForms();
        });
    }
}

function listenSuppr() {
    for (var i = 0; i < buttonsSuppr.length; i += 1) {
        buttonsSuppr[i].addEventListener("click", (e) => {
            let nb = e.target.id.slice("supprButton".length);
            let label = document.getElementById("savedQuestion" + nb).innerText;
            questionsList.remove(label);
            questionsList.display(divSavedQuestions);
            updateForms();
        });
    }
}

function listenChange() {
    Array.from(changeInputs).forEach((element) => {
        element.addEventListener("blur", (e) => {
            let nb = e.target.id.slice("savedQuestion".length);
            questionsList.modify(nb, e.target.innerText);
            questionsList.display(divSavedQuestions);
            updateForms();
        });
    });
}

function updateForms() {
    questionsList.display(divSavedQuestions);
    listen();
    listenSuppr();
    listenChange();
    document.getElementById("formContent").value =
        JSON.stringify(questionsList);
}

function askNewQuestion() {
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
}

function displayTypeMenu() {
    const menu = document.getElementById("menu-types");
    console.log("show");
    menu.style.display === "grid"
        ? (menu.style.display = "none")
        : (menu.style.display = "grid");
}
