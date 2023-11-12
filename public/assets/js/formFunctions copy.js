function listenAddQuestionText() {
    for (var i = 0; i < validateQuestionsCollection.length; i += 1) {
        validateQuestionsCollection[i].addEventListener("click", (e) => {
            let nb = e.target.id.slice("validateQuestion".length);
            let label = document.getElementById("question" + nb).value;
            questionsList.add(new Question(label, nb));
            e.target.parentElement.remove();
            displayAddQuestionMenu();
            updateForms();
        });
    }
}

function listenAddMultipleQuestion() {
    const btn = document.getElementById("validateMultipleQuestion");
    if (btn != undefined) {
        btn.addEventListener("click", () => {
            createMultipleFunction();
            // a voir si create.... return ou fait rirectement
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
    listenAddMultipleQuestion();
    listenAddQuestionText();
    listenSuppr();
    listenChange();
    listenAddProposition();
    listenSupprProposition();
    document.getElementById("formContent").value =
        JSON.stringify(questionsList);
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
            "'><button class='validateQuestion' id='validateQuestion" +
            questionsNb +
            "'>+</button></div>";
    }
    displayTypeMenu();
    displayAddQuestionMenu();
    document.getElementById("question" + questionsNb).focus();
    updateForms();
}
function askNewMultipleQuestion(typeMultipleQuestion) {
    console.log("multiple");
    let questionsNb = questionsList.array.length + 1;
    const divQuestions = document.getElementById("questions");
    if (divQuestions.innerHTML == "") {
        divQuestions.innerHTML +=
            "<div>Quel est le titre de votre question multiple numéro " +
            questionsNb +
            " ?<input type='text' id='question" +
            questionsNb +
            "'>" +
            "<ul class='form-addPropositions' id='addPropositions' type='" +
            typeMultipleQuestion +
            "'>" +
            "<li><input type='text' class='input-addProposition' id='proposition1'></input><button id='addProposition'>+</button><button id='supprProposition'>-</button></li>" +
            "</ul>" +
            "<button class='validateQuestion' id='validateMultipleQuestion'>+</button></div>";
    }

    displayTypeMenu();
    displayAddQuestionMenu();
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
function displayAddQuestionMenu() {
    const menu = document.getElementById("menu-add-question");
    console.log("show add question");
    menu.style.display === "grid"
        ? (menu.style.display = "none")
        : (menu.style.display = "grid");
}

function listenAddProposition() {
    const btn = document.getElementById("addProposition");
    console.log("listenAddProposition");
    if (btn != undefined) {
        console.log("not undefined");
        btn.addEventListener("click", () => {
            addProposition();
        });
    }
}

function addProposition() {
    const addPropositions = document.getElementById("addPropositions");
    let nbProposition = addPropositions.childElementCount;
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
            console.log("suppr");
            supprProposition();
        });
    }
}

function supprProposition() {
    const addPropositions = document.getElementById("addPropositions");
    console.log(addPropositions.childElementCount);
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

function createMultipleFunction() {
    const divQuestions = document.getElementById("questions");
    // label, order, toolid = -1, type = "radio", propositions = [])
    console.log(divQuestions);
    const labelInput = divQuestions.firstChild;
    const orderInput = labelInput.id.slice("question".length);
    const divQuestionUl = divQuestions.firstChild.children[1];
    const typeQuestion = divQuestionUl.type;
    console.log(divQuestionUl);
    const questionMultiple = new QuestionMultiple(
        labelInput.value,
        orderInput,
        -1,
        typeQuestion
    );
    console.log(questionMultiple);

    // return ou pas ?
}