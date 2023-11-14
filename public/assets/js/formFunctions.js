function listenAddQuestion() {
    const validateQuestionsCollection =
        document.getElementsByClassName("validateQuestion");
    for (var i = 0; i < validateQuestionsCollection.length; i += 1) {
        validateQuestionsCollection[i].addEventListener("click", (e) => {
            if (e.target.classList.contains("unique") /*has class unique */) {
                let nb = e.target.id.slice("validateQuestion".length);
                let label = document.getElementById("question" + nb).value;
                questionsList.add(new Question(label, nb));
                e.target.parentElement.remove();
            } else if (
                e.target.classList.contains("multiple") /*has class multiple */
            ) {
                // todo

                questionsList.add(createMultipleQuestion());
            } else {
                //errors
            }
            closeAddQuestionMenu();
            updateForms();
        });
    }
}

function listenSuppr() {
    const buttonsSuppr = document.getElementsByClassName("buttonSuppr");
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
    const changeInputs = document.getElementsByClassName("savedQuestion");
    Array.from(changeInputs).forEach((element) => {
        element.addEventListener("blur", (e) => {
            let nb = e.target.id.slice("savedQuestion".length);
            questionsList.modify(nb, e.target.innerText);
            questionsList.display(divSavedQuestions);
            updateForms();
        });
    });
}

function askNewQuestion() {
    questionsNb = questionsList.array.length + 1;
    const divQuestions = document.getElementById("questions");
    if (divQuestions.innerHTML == "") {
        divQuestions.innerHTML +=
            "<div>Quel est le titre de votre question numéro " +
            questionsNb +
            " ?<input type='text' id='question" +
            questionsNb +
            "'><button class='validateQuestion unique' id='validateQuestion" +
            questionsNb +
            "'>+</button></div>";
    }
    displayTypeMenu();
    displayAddQuestionMenu();
    document.getElementById("question" + questionsNb).focus();
    updateForms();
}

function askNewMultipleQuestion(typeMultipleQuestion) {
    let questionsNb = questionsList.array.length + 1;
    const divQuestions = document.getElementById("questions");
    if (divQuestions.innerHTML == "") {
        divQuestions.innerHTML +=
            "<div><label for='question" +
            questionsNb +
            "'>Quel est le titre de votre question multiple numéro " +
            questionsNb +
            " ?</label><input type='text' id='question" +
            questionsNb +
            "'>" +
            "<ul class='form-addPropositions' id='addPropositions' type='" +
            typeMultipleQuestion +
            "'>" +
            "<li><input type='text' class='input-addProposition' id='addProposition1'></input><button id='addProposition'>+</button><button id='supprProposition'>-</button></li>" +
            "</ul>" +
            "<button class='validateQuestion multiple' id='validateQuestion" +
            questionsNb +
            "'>+</button></div>";
    }

    displayTypeMenu();
    displayAddQuestionMenu();
    document.getElementById("question" + questionsNb).focus();
    updateForms();
}

function askNewRangeQuestion() {
    let questionsNb = questionsList.array.length + 1;
    const divQuestions = document.getElementById("questions");
    if (divQuestions.innerHTML == "") {
        divQuestions.innerHTML +=
            "<div><label for='question" +
            questionsNb +
            "'>Quel est le titre de votre question range numéro " +
            questionsNb +
            " ?</label><input type='text' id='question" +
            questionsNb +
            "'>" +
            "<ul class='form-addPropositions' id='addPropositions' type='" +
            typeMultipleQuestion +
            "'>" +
            "<label for='addProposition1'>Minimum</label>" +
            "<li><input type='number' class='input-addProposition' id='addProposition1'></input></li>" +
            "<label for='addProposition2'>Maximum</label>" +
            "<li><input type='number' class='input-addProposition' id='addProposition2'></input></li>" +
            "<label for='addProposition3'>Pas (granularité)</label>" +
            "<li><input type='number' class='input-addProposition' id='addProposition3'></input></li>" +
            "</ul>" +
            "<button class='validateQuestion multiple' id='validateQuestion" +
            questionsNb +
            "'>+</button></div>";
    }

    displayTypeMenu();
    displayAddQuestionMenu();
    document.getElementById("question" + questionsNb).focus();
    updateForms();
}

function displayTypeMenu() {
    const menu = document.getElementById("menu-types");
    menu.style.display === "grid"
        ? (menu.style.display = "none")
        : (menu.style.display = "grid");
}
function displayAddQuestionMenu() {
    const menu = document.getElementById("menu-add-question");

    menu.style.display === "grid"
        ? (menu.style.display = "none")
        : (menu.style.display = "grid");
}

function listenAddProposition() {
    const btn = document.getElementById("addProposition");

    if (btn != undefined) {
        btn.addEventListener("click", () => {
            addProposition();
        });
    }
}

function addProposition() {
    const addPropositions = document.getElementById("addPropositions");
    let nbProposition = addPropositions.childElementCount + 1;
    const lastProposition = addPropositions.appendChild(
        document.createElement("li")
    );
    lastProposition.innerHTML =
        "<input type='text' classe='addProposition' id='addProposition" +
        nbProposition +
        "'></input>";
}

function listenSupprProposition() {
    const btn = document.getElementById("supprProposition");
    if (btn != undefined) {
        btn.addEventListener("click", () => {
            supprProposition();
        });
    }
}

function supprProposition() {
    const addPropositions = document.getElementById("addPropositions");

    if (addPropositions.childElementCount > 1) {
        addPropositions.removeChild(addPropositions.lastChild);
    }
}

function createProposition(propositionLi) {
    let propositionInput = propositionLi.firstChild;
    let propositionValue = propositionInput.value;
    let nbProposition = propositionInput.id.slice("proposition".length);
    return new Proposition(propositionValue, nbProposition);
}

function createMultipleQuestion() {
    //anciennement createMultipleFunction
    const divQuestions = document.getElementById("questions");
    // label, order, toolid = -1, type = "radio", propositions = [])
    const labelInput = divQuestions.firstChild.children[1];

    const orderInput = labelInput.id.slice("question".length);
    const divQuestionUl = divQuestions.firstChild.children[2];
    const typeQuestion = divQuestionUl.type;

    const questionMultiple = new QuestionMultiple(
        labelInput.value,
        orderInput,
        -1,
        typeQuestion
    );

    Array.from(divQuestionUl.children).forEach((a) => {
        let prop = new Proposition(
            a.firstChild.value,
            a.firstChild.id.slice("addProposition".length)
        );
        questionMultiple.addProposition(prop);
    });

    return questionMultiple;
}

function closeAddQuestionMenu() {
    const element = document.getElementById("questions");
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
    displayAddQuestionMenu();
}
