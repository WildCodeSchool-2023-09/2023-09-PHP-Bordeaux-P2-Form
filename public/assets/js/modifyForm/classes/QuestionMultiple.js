class QuestionMultiple extends Question {
    constructor(label, order, toolid = -1, type = "radio", propositions = []) {
        super(label, order, toolid, type);
        this.propositions = propositions;
    }

    addProposition(proposition) {
        this.propositions.push(proposition);
    }

    displayQuestion() {
        htmlValue =
            "<div class='newQuestion'><div class='savedQuestion' id='savedQuestion" +
            this.order +
            "' toolid='" +
            this.toolid +
            "' tooltype='" +
            this.type +
            "' contenteditable='true'>" +
            this.label +
            "</div><div class='formButtons'><button class='buttonSuppr' id='buttonSuppr" +
            this.order +
            "'>-</button></div>" +
            "<ul><button class='addProposition' id='proposition'>+</button>" +
            "<li>" +
            "" +
            "</li>" +
            "</ul></div>";
        return htmlValue;
    }

    displayPropositions() {}
}
