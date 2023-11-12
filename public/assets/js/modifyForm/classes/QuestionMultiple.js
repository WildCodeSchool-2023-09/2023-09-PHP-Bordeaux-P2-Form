class QuestionMultiple extends Question {
    constructor(label, order, toolid = -1, type = "radio", propositions = []) {
        super(label, order, toolid, type);
        this.propositions = propositions;
    }

    addProposition(proposition) {
        this.propositions.push(proposition);
    }

    addPropositionsFromArray(propositionsArray) {
        propositionsArray.forEach((proposition) => {
            let newProposition = new Proposition(
                proposition.tool_option,
                proposition.choice_order,
                proposition.id
            );
            this.addProposition(newProposition);
        });
    }

    displayQuestion() {
        let id = "savedQuestion" + this.order;
        this.order;
        let htmlValue =
            "<div class='newQuestion'><div class='savedQuestion' id='" +
            id +
            "' toolid='" +
            this.toolid +
            "' tooltype='" +
            this.type +
            "' contenteditable='true'>" +
            this.label +
            "</div><div class='formButtons'><button class='buttonSuppr' id='buttonSuppr" +
            this.order +
            "'>-</button></div></div>" +
            "<ul><button class='addProposition' id='proposition'>+</button>";
        this.propositions.forEach((a) => {
            let toWrite = a.displayProposition(id);
            htmlValue += toWrite;
        });

        htmlValue += "</ul></div>";
        return htmlValue;
    }
}
